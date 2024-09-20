<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\States\Loan;

use Domain\Loan\Shared\Menus\AboutLoan\AboutLoansMenu;
use Domain\Loan\Shared\Menus\GetLoan\GetLoanMenu;
use Domain\Loan\Shared\Menus\Loan\LoanMenu;
use Domain\Loan\Shared\Menus\LoanTerms\LoanTermsMenu;
use Domain\Loan\Shared\States\AboutLoan\AboutLoansState;
use Domain\Loan\Shared\States\GetLoan\GetLoanState;
use Domain\Loan\Shared\States\LoanTerms\LoanTermsState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyLoanAccounts\MyLoanAccountsMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyLoanAccounts\MyLoanAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyLoanAccountsState, 'menu' => new MyLoanAccountsMenu],
            '2' => ['class' => new GetLoanState, 'menu' => new GetLoanMenu],
            '3' => ['class' => new AboutLoansState, 'menu' => new AboutLoansMenu],
            '4' => ['class' => new LoanTermsState, 'menu' => new LoanTermsMenu],
            '0' => ['class' => new CustomerWelcomeState, 'menu' => new CustomerWelcomeMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($service_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the LoanMenu(invalidMainMenu)
        return LoanMenu::invalidMainMenu(session: $session);
    }
}
