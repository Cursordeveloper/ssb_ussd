<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance;

use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceState;
use App\States\ExistingCustomer\Insurance\Accounts\InsuranceAccountsState;
use App\States\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceBalance\InsuranceBalanceState;
use App\States\ExistingCustomer\Insurance\InsuranceClaims\InsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new InsuranceAccountsState,
            '2' => new CreateInsuranceState,
            '3' => new InsuranceBalanceState,
            '4' => new AboutInsuranceState,
            '5' => new InsuranceTermsState,
            '6' => new InsuranceClaimsState,
            '0' => new ExistingCustomerState,
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute(session: $session, session_data: $session_data);
        }

        // Return the InsuranceMenu(invalidMainMenu)
        return InsuranceMenu::invalidMainMenu(session: $session);
    }
}
