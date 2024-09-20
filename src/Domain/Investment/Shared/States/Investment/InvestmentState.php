<?php

declare(strict_types=1);

namespace Domain\Investment\Shared\States\Investment;

use Domain\Investment\Shared\Menus\AboutInvestment\AboutInvestmentMenu;
use Domain\Investment\Shared\Menus\InvestmentTerms\InvestmentTermsMenu;
use Domain\Investment\Shared\Menus\StartInvestment\StartInvestmentMenu;
use Domain\Investment\Shared\States\AboutInvestment\AboutInvestmentState;
use Domain\Investment\Shared\States\InvestmentTerms\InvestmentTermsState;
use Domain\Investment\Shared\States\StartInvestment\StartInvestmentState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyInvestmentAccounts\MyInvestmentAccountsMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyInvestmentAccounts\MyInvestmentAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MyInvestmentAccountsState, 'menu' => new MyInvestmentAccountsMenu],
            '2' => ['class' => new StartInvestmentState, 'menu' => new StartInvestmentMenu],
            '3' => ['class' => new AboutInvestmentState, 'menu' => new AboutInvestmentMenu],
            '4' => ['class' => new InvestmentTermsState, 'menu' => new InvestmentTermsMenu],
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

        // Return the InvestmentMenu(invalidMainMenu)
        return MyInvestmentAccountsMenu::invalidMainMenu(session: $session);
    }
}
