<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\ExistingCustomer\Investment\AboutInvestment\AboutInvestmentMenu;
use App\Menus\ExistingCustomer\Investment\CreateInvestment\CreateInvestmentMenu;
use App\Menus\ExistingCustomer\Investment\InvestmentTerms\InvestmentTermsMenu;
use App\Menus\ExistingCustomer\Investment\MyInvestmentAccounts\MyInvestmentAccountsMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use App\States\ExistingCustomer\Investments\CreateInvestment\StartInvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentTerms\InvestmentTermsState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\MyInvestmentsState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyInvestmentsState, 'menu' => new MyInvestmentAccountsMenu],
            '2' => ['class' => new StartInvestmentState, 'menu' => new CreateInvestmentMenu],
            '3' => ['class' => new AboutInvestmentState, 'menu' => new AboutInvestmentMenu],
            '4' => ['class' => new InvestmentTermsState, 'menu' => new InvestmentTermsMenu],
            '0' => ['class' => new ExistingCustomerState, 'menu' => new ExistingCustomerMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the InvestmentMenu(invalidMainMenu)
        return MyInvestmentAccountsMenu::invalidMainMenu(session: $session);
    }
}
