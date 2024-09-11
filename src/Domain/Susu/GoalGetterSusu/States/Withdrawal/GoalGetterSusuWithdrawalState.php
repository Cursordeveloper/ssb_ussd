<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Withdrawal;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Account\GoalGetterSusuAccountMenu;
use Domain\Susu\GoalGetterSusu\Menus\Withdrawal\GoalGetterSusuWithdrawalFullMenu;
use Domain\Susu\GoalGetterSusu\Menus\Withdrawal\GoalGetterSusuWithdrawalMenu;
use Domain\Susu\GoalGetterSusu\Menus\Withdrawal\GoalGetterSusuWithdrawalPartialMenu;
use Domain\Susu\GoalGetterSusu\States\Account\GoalGetterSusuAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuWithdrawalState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new GoalGetterSusuWithdrawalPartialState, 'menu' => new GoalGetterSusuWithdrawalPartialMenu],
            '2' => ['state' => new GoalGetterSusuWithdrawalFullState, 'menu' => new GoalGetterSusuWithdrawalFullMenu],
            '0' => ['state' => new GoalGetterSusuAccountState, 'menu' => new GoalGetterSusuAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $payment_type_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($payment_type_state['state']), session_data: $session_data);

            // Execute the state
            return $payment_type_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return GoalGetterSusuWithdrawalMenu::invalidMainMenu(session: $session);
    }
}
