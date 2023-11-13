<?php

declare(strict_types=1);

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use App\Menus\Welcome\WelcomeMenu;
use App\States\Registration\RegistrationState;
use App\States\TermsAndConditions\TermsAndConditionsState;
use Domain\Shared\Action\SessionGetAction;
use Domain\Shared\Action\SessionUpdateAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewCustomerState
{
    public static function execute(Request $request): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2', '0'];

        // Get the customer session
        $session = SessionGetAction::execute(data_get(target: $request, key: 'SessionId'));

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Check if use input is in the array
        if (in_array($customer_input, haystack: $options) && $customer_input == "1") {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'RegistrationState');

            // Return the RegistrationState
            return RegistrationState::execute($request);
        } elseif (in_array($customer_input, haystack: $options) && $customer_input == "2") {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'TermsAndConditionsState');

            // Return the TermsAndConditionsState
            return TermsAndConditionsState::execute($request);
        } elseif (in_array($customer_input, haystack: $options) && $customer_input == "0") {
            // Delete customer session
            return ResponseBuilder::terminateResponseBuilder(
                session_id: data_get(target: $request, key: 'SessionId'),
            );
        }

        // Return the newCustomerInvalidOption
        return WelcomeMenu::newCustomerInvalidOption(data_get(target: $request, key: 'SessionId'));
    }
}
