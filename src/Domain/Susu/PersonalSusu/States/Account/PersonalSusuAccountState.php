<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Account;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountPauseMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountPauseState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Menus\Susu\Balance\SusuAccountBalanceMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Susu\Balance\SusuAccountBalanceState;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\Menus\Collection\PersonalSusuCollectionSummaryMenu;
use Domain\Susu\PersonalSusu\Menus\Payment\PersonalSusuPaymentMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementMenu;
use Domain\Susu\PersonalSusu\States\Collection\PersonalSusuCollectionSummaryState;
use Domain\Susu\PersonalSusu\States\Payment\PersonalSusuPaymentState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementState;
use Domain\Susu\Shared\Menus\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\SusuMiniStatementState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],
            '2' => ['state' => new PersonalSusuPaymentState, 'menu' => new PersonalSusuPaymentMenu],
            '3' => ['state' => new PersonalSusuSettlementState, 'menu' => new PersonalSusuSettlementMenu],
            '4' => ['state' => new PersonalSusuCollectionSummaryState, 'menu' => new PersonalSusuCollectionSummaryMenu],

            '5' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],

            '6' => ['state' => new SusuAccountPauseState, 'menu' => new SusuAccountPauseMenu],
            '7' => ['state' => new SusuAccountCloseState, 'menu' => new SusuAccountCloseMenu],

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
        return PersonalSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
