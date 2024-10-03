<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\Welcome;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\TermsAndConditions\TermsAndConditionsMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\AboutSusuBox\AboutSusuboxState;
use Domain\Shared\States\TermsAndConditions\TermsAndConditionsState;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\States\Susu\SusuState;
use Domain\User\Customer\Menus\MyAccount\MyAccountMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyAccount\MyAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerWelcomeState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        return match (true) {
            $service_data->user_input === '0' => GeneralMenu::terminateSession(session: $session),

            default => self::stateExecution(session: $session, service_data: $service_data),
        };
    }

    private static function stateExecution(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuState, 'menu' => new SusuMenu],
            '2' => ['class' => new AboutSusuboxState, 'menu' => new AboutSusuboxMenu],
            '3' => ['class' => new TermsAndConditionsState, 'menu' => new TermsAndConditionsMenu],
            '4' => ['class' => new MyAccountState, 'menu' => new MyAccountMenu],
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

        // Return the invalidMainMenu
        return CustomerWelcomeMenu::invalidMainMenu(session: $session);
    }
}
