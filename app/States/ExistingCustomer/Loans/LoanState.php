<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans;

use App\Menus\ExistingCustomer\Loan\LoanMenu;
use App\States\ExistingCustomer\Loans\AboutLoans\AboutLoansState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\LoanBalance\LoanBalanceState;
use App\States\ExistingCustomer\Loans\LoanPayment\LoanPaymentState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new GetLoanState,
            '2' => new LoanPaymentState,
            '3' => new LoanBalanceState,
            '4' => new AboutLoansState,
            '5' => new LoanTermsState,
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

        // Return the MyAccountMenu
        return LoanMenu::invalidMainMenu(session: $session);
    }
}
