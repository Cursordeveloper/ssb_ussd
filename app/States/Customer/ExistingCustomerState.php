<?php

declare(strict_types=1);

namespace App\States\Customer;

use App\Common\ResponseBuilder;
use App\Menus\Welcome\WelcomeMenu;
use App\States\Account\MyAccountState;
use App\States\Insurance\InsuranceState;
use App\States\Investments\InvestmentsState;
use App\States\Loans\LoansState;
use App\States\Susu\SusuSavingsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExistingCustomerState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Create the expected input arrays
        $options = ['1', '2', '3', '4', '5', '0'];

        // Assign the customer input to a variable
        $customer_input = data_get(target: $request, key: 'Message');

        // Execute if customer option valid and its 1
        if (in_array($customer_input, $options) && $customer_input === '1') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'SusuSavingsState');

            // Return the SusuSavingsState
            return SusuSavingsState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 2
        if (in_array($customer_input, $options) && $customer_input === '2') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'LoansState');

            // Return the LoansState
            return LoansState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 3
        if (in_array($customer_input, $options) && $customer_input === '3') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'InvestmentsState');

            // Return the InvestmentsState
            return InvestmentsState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 4
        if (in_array($customer_input, $options) && $customer_input === '4') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'InsuranceState');

            // Return the InvestmentsState
            return InsuranceState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 5
        if (in_array($customer_input, $options) && $customer_input === '5') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'MyAccountState');

            // Return the InvestmentsState
            return MyAccountState::execute(session: $session, request: $request);
        }

        // Execute if customer option valid and its 0
        if (in_array($customer_input, $options) && $customer_input === '0') {
            return ResponseBuilder::terminateResponseBuilder(session_id: data_get(target: $session, key: 'session_id'));
        }

        // The customer input is invalid
        return WelcomeMenu::existingCustomerInvalidOption(data_get(target: $session, key: 'session_id'));
    }
}
