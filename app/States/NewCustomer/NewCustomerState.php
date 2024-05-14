<?php

declare(strict_types=1);

namespace App\States\NewCustomer;

use App\Menus\NewCustomer\NewCustomerMenu;
use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\NewCustomer\TermsAndConditions\TermsAndConditionsMenu;
use App\Menus\Shared\AboutSusubox\AboutSusuboxMenu;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;
use App\States\Shared\AboutSusubox\AboutSusuboxState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewCustomerState
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
        return NewCustomerMenu::newCustomerInvalidOption($session);
    }
}
