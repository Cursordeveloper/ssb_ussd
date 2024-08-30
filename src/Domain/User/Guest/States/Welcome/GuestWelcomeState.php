<?php

declare(strict_types=1);

namespace Domain\User\Guest\States\Welcome;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Menus\TermsAndConditions\TermsAndConditionsMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\AboutSusuBox\AboutSusuboxState;
use Domain\Shared\States\TermsAndConditions\TermsAndConditionsState;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Domain\User\Guest\Menus\Welcome\GuestWelcomeMenu;
use Domain\User\Guest\States\Registration\RegistrationState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GuestWelcomeState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new RegistrationState, 'menu' => new RegistrationMenu],
            '2' => ['class' => new AboutSusuboxState, 'menu' => new AboutSusuboxMenu],
            '3' => ['class' => new TermsAndConditionsState, 'menu' => new TermsAndConditionsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu($session, $session_data);
        }

        // The customer input is invalid
        return GuestWelcomeMenu::newCustomerInvalidOption($session);
    }
}
