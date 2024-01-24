<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\AboutLoansMenu;
use App\Menus\ExistingCustomer\Loan\GetLoan\GetLoanMenu;
use App\Menus\ExistingCustomer\Loan\LoanMenu;
use App\Menus\ExistingCustomer\Loan\LoanTerms\LoanTermsMenu;
use App\Menus\ExistingCustomer\Loan\MyLoans\MyLoansMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Loans\AboutLoans\AboutLoansState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use App\States\ExistingCustomer\Loans\MyLoans\MyLoansState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyLoansState, 'menu' => new MyLoansMenu],
            '2' => ['class' => new GetLoanState, 'menu' => new GetLoanMenu],
            '3' => ['class' => new AboutLoansState, 'menu' => new AboutLoansMenu],
            '4' => ['class' => new LoanTermsState, 'menu' => new LoanTermsMenu],
            '0' => ['class' => new ExistingCustomerState, 'menu' => new ExistingCustomerMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session, session_data: $session_data);
        }

        // Return the LoanMenu(invalidMainMenu)
        return LoanMenu::invalidMainMenu(session: $session);
    }
}
