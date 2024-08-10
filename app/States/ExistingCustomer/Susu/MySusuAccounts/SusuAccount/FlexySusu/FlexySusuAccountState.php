<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountPaymentMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Menus\Susu\Balance\SusuAccountBalanceMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Susu\Balance\SusuAccountBalanceState;
use Domain\Susu\FlexySusu\Menus\Withdrawal\FlexySusuAccountWithdrawalMenu;
use Domain\Susu\FlexySusu\States\Withdrawal\FlexySusuAccountWithdrawalState;
use Domain\Susu\PersonalSusu\Menus\Pause\PersonalSusuCollectionPauseMenu;
use Domain\Susu\PersonalSusu\States\Pause\PersonalSusuCollectionPauseState;
use Domain\Susu\Shared\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\MySusuAccounts\MySusuAccountsState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],

            '2' => ['state' => new FlexySusuAccountPaymentState, 'menu' => new FlexySusuAccountPaymentMenu],
            '3' => ['state' => new FlexySusuAccountWithdrawalState, 'menu' => new FlexySusuAccountWithdrawalMenu],

            '4' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '5' => ['state' => new PersonalSusuCollectionPauseState, 'menu' => new PersonalSusuCollectionPauseMenu],
            '6' => ['state' => new SusuAccountCloseState, 'menu' => new SusuAccountCloseMenu],

            '0' => ['state' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['state']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return FlexySusuAccountMenu::invalidMainMenu(session: $session);
    }
}
