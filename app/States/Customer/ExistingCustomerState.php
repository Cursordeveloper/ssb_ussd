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

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new SusuSavingsState,
            '2' => new LoansState,
            '3' => new InvestmentsState,
            '4' => new InsuranceState,
            '5' => new MyAccountState,
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
        return WelcomeMenu::existingCustomerInvalidOption(data_get(target: $session, key: 'session_id'));
    }
}
