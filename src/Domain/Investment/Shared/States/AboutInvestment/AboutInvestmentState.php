<?php

declare(strict_types=1);

namespace Domain\Investment\Shared\States\AboutInvestment;

use Domain\Investment\Shared\Menus\AboutInvestment\AboutInvestmentMenu;
use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentCommissions\InvestmentCommissionsMenu;
use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentContributions\InvestmentContributionsMenu;
use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentReturns\InvestmentReturnsMenu;
use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentSchemes\InvestmentSchemesMenu;
use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentWithdrawals\InvestmentWithdrawalsMenu;
use Domain\Investment\Shared\Menus\Investment\InvestmentMenu;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentCommissions\InvestmentCommissionsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentContributions\InvestmentContributionsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentReturns\InvestmentReturnsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentSchemes\InvestmentSchemesState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentWithdrawals\InvestmentWithdrawalsState;
use Domain\Investment\Shared\States\Investment\InvestmentState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new InvestmentSchemesState, 'menu' => new InvestmentSchemesMenu],
            '2' => ['class' => new InvestmentContributionsState, 'menu' => new InvestmentContributionsMenu],
            '3' => ['class' => new InvestmentReturnsState, 'menu' => new InvestmentReturnsMenu],
            '4' => ['class' => new InvestmentWithdrawalsState, 'menu' => new InvestmentWithdrawalsMenu],
            '5' => ['class' => new InvestmentCommissionsState, 'menu' => new InvestmentCommissionsMenu],
            '0' => ['class' => new InvestmentState, 'menu' => new InvestmentMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutInvestmentMenu::mainMenu(session: $session);
    }
}
