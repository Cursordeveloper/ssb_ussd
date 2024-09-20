<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\States\AboutLoan;

use Domain\Loan\Shared\Menus\AboutLoan\AboutLoansMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanApplication\LoanApplicationMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanCollateral\LoanCollateralMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanDisbursement\LoanDisbursementsMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanInterest\LoanInterestsMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanQualification\LoanQualificationMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanRepayment\LoanRepaymentsMenu;
use Domain\Loan\Shared\Menus\AboutLoan\LoanSchemes\LoanSchemesMenu;
use Domain\Loan\Shared\Menus\Loan\LoanMenu;
use Domain\Loan\Shared\States\AboutLoan\LoanApplication\AboutLoanApplicationState;
use Domain\Loan\Shared\States\AboutLoan\LoanCollateral\AboutLoanCollateralState;
use Domain\Loan\Shared\States\AboutLoan\LoanDisbursement\AboutLoanDisbursementState;
use Domain\Loan\Shared\States\AboutLoan\LoanInterest\AboutLoanInterestState;
use Domain\Loan\Shared\States\AboutLoan\LoanQualification\AboutLoanQualificationState;
use Domain\Loan\Shared\States\AboutLoan\LoanRepayment\AboutLoanRepaymentState;
use Domain\Loan\Shared\States\AboutLoan\LoanSchemes\AboutLoanSchemesState;
use Domain\Loan\Shared\States\Loan\LoanState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutLoansState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutLoanSchemesState, 'menu' => new LoanSchemesMenu],
            '2' => ['class' => new AboutLoanQualificationState, 'menu' => new LoanQualificationMenu],
            '3' => ['class' => new AboutLoanApplicationState, 'menu' => new LoanApplicationMenu],
            '4' => ['class' => new AboutLoanCollateralState, 'menu' => new LoanCollateralMenu],
            '5' => ['class' => new AboutLoanDisbursementState, 'menu' => new LoanDisbursementsMenu],
            '6' => ['class' => new AboutLoanRepaymentState, 'menu' => new LoanRepaymentsMenu],
            '7' => ['class' => new AboutLoanInterestState, 'menu' => new LoanInterestsMenu],
            '0' => ['class' => new LoanState, 'menu' => new LoanMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $service_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutLoansMenu::mainMenu(session: $session);
    }
}
