<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Account;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Account\GoalGetterSusuAccountMenu;
use Domain\Susu\GoalGetterSusu\Menus\Payment\GoalGetterSusuPaymentMenu;
use Domain\Susu\GoalGetterSusu\Menus\Withdrawal\GoalGetterSusuWithdrawalMenu;
use Domain\Susu\GoalGetterSusu\States\Payment\GoalGetterSusuPaymentState;
use Domain\Susu\GoalGetterSusu\States\Withdrawal\GoalGetterSusuWithdrawalState;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\Susu\Shared\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\MySusuAccounts\MySusuAccountsState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['state' => new GoalGetterSusuPaymentState, 'menu' => new GoalGetterSusuPaymentMenu],
            '3' => ['state' => new GoalGetterSusuWithdrawalState, 'menu' => new GoalGetterSusuWithdrawalMenu],
            '4' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
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
        return GoalGetterSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
