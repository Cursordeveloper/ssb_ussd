<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Payment;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Account\BizSusuAccountMenu;
use Domain\Susu\BizSusu\Menus\Payment\BizSusuPaymentAmountMenu;
use Domain\Susu\BizSusu\Menus\Payment\BizSusuPaymentFrequencyMenu;
use Domain\Susu\BizSusu\Menus\Payment\BizSusuPaymentMenu;
use Domain\Susu\BizSusu\States\Account\BizSusuAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuPaymentState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new BizSusuPaymentFrequencyState, 'menu' => new BizSusuPaymentFrequencyMenu],
            '2' => ['state' => new BizSusuPaymentAmountState, 'menu' => new BizSusuPaymentAmountMenu],
            '0' => ['state' => new BizSusuAccountState, 'menu' => new BizSusuAccountMenu],
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
        return BizSusuPaymentMenu::invalidMainMenu(session: $session);
    }
}
