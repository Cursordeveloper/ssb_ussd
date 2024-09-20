<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Withdrawal;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Withdrawal\BizSusuWithdrawalFullMenu;
use Domain\Susu\BizSusu\Menus\Withdrawal\BizSusuWithdrawalMenu;
use Domain\Susu\BizSusu\Menus\Withdrawal\BizSusuWithdrawalPartialMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new BizSusuWithdrawalPartialState, 'menu' => new BizSusuWithdrawalPartialMenu],
            '2' => ['state' => new BizSusuWithdrawalFullState, 'menu' => new BizSusuWithdrawalFullMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($service_data->user_input, $stateMappings)) {
            // Get the customer option state
            $payment_type_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($payment_type_state['state']), service_data: $service_data);

            // Execute the state
            return $payment_type_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return BizSusuWithdrawalMenu::invalidMainMenu(session: $session);
    }
}
