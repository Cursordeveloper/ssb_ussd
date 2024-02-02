<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\AboutInvestment;

use App\Menus\ExistingCustomer\Investment\AboutInvestment\AboutInvestmentMenu;
use App\Menus\ExistingCustomer\Investment\InvestmentMenu;
use App\States\ExistingCustomer\Investments\InvestmentState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '0' => ['class' => new InvestmentState, 'menu' => new InvestmentMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutInvestmentMenu::mainMenu(session: $session);
    }
}
