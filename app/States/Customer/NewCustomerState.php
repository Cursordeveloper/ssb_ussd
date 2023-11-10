<?php

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\GetSessionAction;
use Domain\Shared\Action\UpdateSessionAction;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewCustomerState
{
    public static function execute(
        array $request,
    ): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2'];

        // Get the customer session
        $session = GetSessionAction::execute(data_get(target: $request, key: 'SessionId'));

        // Check if use input is in the array
        if (in_array(data_get(target: $request, key: 'Message'), haystack: $options) && data_get(target: $request, key: 'Message') === "1") {
            // Update the customer session action
            UpdateSessionAction::execute(
                session: $session,
                state: 'RegistrationState',
            );

            // Return the registration state
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: "Enter First Name\n",
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        } elseif (in_array(data_get(target: $request, key: 'Message'), haystack: $options) && data_get(target: $request, key: 'Message') === "2") {
            // Update the customer session action
            UpdateSessionAction::execute(
                session: $session,
                state: 'TermsAndConditionsState',
            );

            // Return the terms and conditions state
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.\n\n #. Next",
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
