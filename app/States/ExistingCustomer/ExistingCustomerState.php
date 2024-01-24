<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use App\Menus\ExistingCustomer\Investment\MyInvestments\MyInvestmentsMenu;
use App\Menus\ExistingCustomer\Loan\LoanMenu;
use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Investments\InvestmentState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ExistingCustomerState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuState, 'menu' => new SusuMenu],
            '2' => ['class' => new LoanState, 'menu' => new LoanMenu],
            '3' => ['class' => new InvestmentState, 'menu' => new MyInvestmentsMenu],
            '4' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
            '5' => ['class' => new MyAccountState, 'menu' => new MyAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return ExistingCustomerMenu::invalidMainMenu(session: $session);
    }
}
