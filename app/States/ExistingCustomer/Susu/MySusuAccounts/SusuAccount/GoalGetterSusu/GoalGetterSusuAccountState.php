<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\GoalGetterSusuAccountLiquidationMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountMiniStatementMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountMiniStatementState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],

            '2' => ['state' => new GoalGetterSusuAccountLiquidationState, 'menu' => new GoalGetterSusuAccountLiquidationMenu],
            '3' => ['state' => new SusuAccountMiniStatementState, 'menu' => new SusuAccountMiniStatementMenu],

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
        return SusuAccountMenu::invalidMainMenu(session: $session);
    }
}
