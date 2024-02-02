<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance\AboutInsurance;

use App\Menus\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '0' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutInsuranceMenu::mainMenu(session: $session);
    }
}
