<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\AboutLoans;

use App\Menus\ExistingCustomer\Loan\AboutLoans\AboutLoansMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanApplication\LoanApplicationMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanCollateral\LoanCollateralMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanDisbursements\LoanDisbursementsMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanInterests\LoanInterestsMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanQualification\LoanQualificationMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanRepayments\LoanRepaymentsMenu;
use App\Menus\ExistingCustomer\Loan\AboutLoans\LoanSchemes\LoanSchemesMenu;
use App\Menus\ExistingCustomer\Loan\LoanMenu;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanApplication\AboutLoanApplicationState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanCollateral\AboutLoanCollateralState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanDisbursements\AboutLoanDisbursementsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanInterests\AboutLoanInterestsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanQualification\AboutLoanQualificationState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanRepayments\AboutLoanRepaymentsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanSchemes\AboutLoanSchemesState;
use App\States\ExistingCustomer\Loans\LoanState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutLoansState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutLoanSchemesState, 'menu' => new LoanSchemesMenu],
            '2' => ['class' => new AboutLoanQualificationState, 'menu' => new LoanQualificationMenu],
            '3' => ['class' => new AboutLoanApplicationState, 'menu' => new LoanApplicationMenu],
            '4' => ['class' => new AboutLoanCollateralState, 'menu' => new LoanCollateralMenu],
            '5' => ['class' => new AboutLoanDisbursementsState, 'menu' => new LoanDisbursementsMenu],
            '6' => ['class' => new AboutLoanRepaymentsState, 'menu' => new LoanRepaymentsMenu],
            '7' => ['class' => new AboutLoanInterestsState, 'menu' => new LoanInterestsMenu],
            '0' => ['class' => new LoanState, 'menu' => new LoanMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutLoansMenu::mainMenu(session: $session);
    }
}
