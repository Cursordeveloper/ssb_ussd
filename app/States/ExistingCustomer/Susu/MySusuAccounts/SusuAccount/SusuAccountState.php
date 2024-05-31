<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountPaymentMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\FlexySusuAccountWithdrawalMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountMiniStatementMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountPauseMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\FlexySusuAccountWithdrawalState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountMiniStatementState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountPauseState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],
            '2' => ['class' => new FlexySusuAccountPaymentState, 'menu' => new FlexySusuAccountPaymentMenu],
            '3' => ['class' => new FlexySusuAccountWithdrawalState, 'menu' => new FlexySusuAccountWithdrawalMenu],
            '4' => ['class' => new SusuAccountMiniStatementState, 'menu' => new SusuAccountMiniStatementMenu],
            '5' => ['class' => new SusuAccountPauseState, 'menu' => new SusuAccountPauseMenu],
            '6' => ['class' => new SusuAccountCloseState, 'menu' => new SusuAccountCloseMenu],
            '0' => ['class' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return SusuAccountMenu::invalidMainMenu(session: $session);
    }
}
