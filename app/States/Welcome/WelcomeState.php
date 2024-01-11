<?php

namespace App\States\Welcome;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Welcome\WelcomeMenu;
use Domain\Shared\Action\Customer\HasPinAction;
use Domain\Shared\Action\Customer\IsActiveAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(Session $session): JsonResponse
    {
        // Customer has not created a pin
        if (HasPinAction::execute(session: $session)) {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'RegistrationState', session_data: $session);

            // Return the choose pin prompt to the customer
            return RegistrationMenu::choosePin(session: $session);
        }

        // Customer is not activated
        if (IsActiveAction::execute(session: $session)) {
            // Update the session state
            SessionUpdateAction::execute(session: $session, state: 'ExistingCustomerState', session_data: $session);

            // Return the existing customer menu
            return WelcomeMenu::existingCustomer($session);
        }

        // Update the session state
        SessionUpdateAction::execute(session: $session, state: 'NewCustomerState', session_data: $session);

        // Return the new customer menu
        return WelcomeMenu::newCustomer(session: $session);
    }
}
