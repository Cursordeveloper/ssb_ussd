<?php

declare(strict_types=1);

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use App\States\Registration\RegistrationState;
use App\States\TermsAndConditions\TermsAndConditionsState;
use Domain\Shared\Action\GetSessionAction;
use Domain\Shared\Action\UpdateSessionAction;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewCustomerState
{
    public static function execute(
        array $request,
    ): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2', '0'];

        // Get the customer session
        $session = GetSessionAction::execute(data_get(target: $request, key: 'SessionId'));

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Check if use input is in the array
        if (in_array($customer_input, haystack: $options) && $customer_input == "1") {
            // Update the customer session action
            UpdateSessionAction::execute(session: $session, state: 'RegistrationState');

            return RegistrationState::execute($request);
        } elseif (in_array($customer_input, haystack: $options) && $customer_input == "2") {
            // Update the customer session action
            UpdateSessionAction::execute(session: $session, state: 'TermsAndConditionsState');

            return TermsAndConditionsState::execute($request);
        } elseif (in_array($customer_input, haystack: $options) && $customer_input == "0") {
            // Delete customer session
            return ResponseBuilder::terminateResponseBuilder(
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // The customer input is invalid
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input. Try again\n\n1. Register now\n2. Terms & Conditions\n0. Exit",
            session_id: data_get(target: $request, key: 'SessionId'),
        );
    }
}
