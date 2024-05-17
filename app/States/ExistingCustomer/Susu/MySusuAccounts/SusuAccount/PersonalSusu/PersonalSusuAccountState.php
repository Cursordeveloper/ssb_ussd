<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\PersonalSusu;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\PersonalSusu\PersonalSusuAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\PersonalSusu\PersonalSusuAccountSettlementMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\PersonalBizSusuAccountPaymentMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuCloseAccount\SusuAccountCloseMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuMiniStatement\SusuAccountMiniStatementMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPauseAccount\SusuAccountPauseMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\PersonalBizSusuAccountPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountClose\SusuAccountCloseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMiniStatement\SusuAccountMiniStatementState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountPause\SusuAccountPauseState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],
            '2' => ['state' => new PersonalBizSusuAccountPaymentState, 'menu' => new PersonalBizSusuAccountPaymentMenu],

            '3' => ['state' => new PersonalSusuAccountSettlementState, 'menu' => new PersonalSusuAccountSettlementMenu],
            '4' => ['state' => new SusuAccountMiniStatementState, 'menu' => new SusuAccountMiniStatementMenu],

            '5' => ['state' => new SusuAccountPauseState, 'menu' => new SusuAccountPauseMenu],
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
        return PersonalSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
