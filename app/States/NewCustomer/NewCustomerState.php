<?php

declare(strict_types=1);

namespace App\States\NewCustomer;

use App\Menus\Shared\GeneralMenu;
use App\Menus\Welcome\WelcomeMenu;
use App\States\NewCustomer\AboutSusubox\AboutSusuboxState;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewCustomerState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Create the expected input arrays
        $options = ['1', '2', '3', '0'];

        // If the input is '0', terminate the session
        if ($session_data->user_input === '0') {
            return GeneralMenu::terminateSession(session: $session);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new RegistrationState,
            '2' => new AboutSusuboxState,
            '3' => new TermsAndConditionsState,
            '0' => null,
        ];

        // Check if the customer input is a valid option
        if (in_array($session_data->user_input, $options) && array_key_exists($session_data->user_input, $stateMappings)) {
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute($session, $session_data);
        }

        // The customer input is invalid
        return WelcomeMenu::newCustomerInvalidOption($session);
    }
}
