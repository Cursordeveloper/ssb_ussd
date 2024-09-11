<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\Welcome;

use Domain\Insurance\Shared\Menus\Insurance\InsuranceMenu;
use Domain\Insurance\Shared\States\Insurance\InsuranceState;
use Domain\Investment\Shared\Menus\Investment\InvestmentMenu;
use Domain\Investment\Shared\States\Investment\InvestmentState;
use Domain\Loan\Shared\Menus\Loan\LoanMenu;
use Domain\Loan\Shared\States\Loan\LoanState;
use Domain\Pension\Shared\Menus\Pension\PensionMenu;
use Domain\Pension\Shared\States\Pension\PensionState;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\AboutSusuBox\AboutSusuboxState;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\States\Susu\SusuState;
use Domain\User\Customer\Menus\MyAccount\MyAccountMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyAccount\MyAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerWelcomeState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuState, 'menu' => new SusuMenu],
            '2' => ['class' => new LoanState, 'menu' => new LoanMenu],
            '3' => ['class' => new InvestmentState, 'menu' => new InvestmentMenu],
            '4' => ['class' => new InsuranceState, 'menu' => new InsuranceMenu],
            '5' => ['class' => new PensionState, 'menu' => new PensionMenu],
            '6' => ['class' => new AboutSusuboxState, 'menu' => new AboutSusuboxMenu],
            '7' => ['class' => new MyAccountState, 'menu' => new MyAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return CustomerWelcomeMenu::invalidMainMenu(session: $session);
    }
}
