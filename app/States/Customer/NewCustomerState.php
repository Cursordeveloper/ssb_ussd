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

        // Get the customer session
        $session = SessionGetAction::execute(session_id: data_get(target: $session, key: 'session_id'));

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Execute if customer option valid and its 1
        if (in_array($customer_input, $options) && $customer_input === '1') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'RegistrationState');

            // Return the RegistrationState
            return RegistrationState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 2
        if (in_array($customer_input, $options) && $customer_input === '2') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'TermsAndConditionsState');

            // Return the TermsAndConditionsState
            return TermsAndConditionsState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 0
        if (in_array($customer_input, $options) && $customer_input === '0') {
            // Delete customer session

            // Return the terminateResponseBuilder
            return ResponseBuilder::terminateResponseBuilder(session_id: data_get(target: $session, key: 'session_id'));
        }

        // Return the newCustomerInvalidOption
        return WelcomeMenu::newCustomerInvalidOption(data_get(target: $session, key: 'session_id'));
    }
}
