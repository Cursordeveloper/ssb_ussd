<?php

declare(strict_types=1);

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use App\Menus\Welcome\WelcomeMenu;
use App\States\Registration\RegistrationState;
use App\States\TermsAndConditions\TermsAndConditionsState;
use Domain\Shared\Action\SessionGetAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewCustomerState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2', '0'];

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new RegistrationState,
            '2' => new TermsAndConditionsState,
            '0' => null,
        ];

        // Check if the customer input is a valid option
        if (in_array($customer_input, $options) && array_key_exists($customer_input, $stateMappings)) {
            $customer_state = $stateMappings[$customer_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state));

            // If the input is '0', terminate the session
            if ($customer_input === '0') {
                return ResponseBuilder::terminateResponseBuilder(session_id: data_get(target: $session, key: 'session_id'));
            }

            // Execute the state
            return $customer_state::execute(session: $session, request: $request);
        }

        // The customer input is invalid
        return WelcomeMenu::newCustomerInvalidOption(data_get(target: $session, key: 'session_id'));
    }
}
