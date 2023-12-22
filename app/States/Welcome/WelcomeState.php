<?php

namespace App\States\Welcome;

use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\Menus\Welcome\WelcomeMenu;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(Session $session): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Customer has not created a pin
        if ($customer && data_get(target: $customer, key: 'status') === 'active' && $customer['has_pin'] !== true) {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'RegistrationState', session_data: $session);

            // Return the choose pin prompt to the customer
            return RegistrationMenu::choosePin($session);
        }

        // Customer is not activated
        if ($customer && data_get(target: $customer, key: 'status') === 'active') {
            // Update the session state
            SessionUpdateAction::execute(session: $session, state: 'ExistingCustomerState', session_data: $session);

            // Return the existing customer menu
            return WelcomeMenu::existingCustomer($session);
        }

        // Update the session state
        SessionUpdateAction::execute(session: $session, state: 'NewCustomerState', session_data: $session);

        // Return the new customer menu
        return WelcomeMenu::newCustomer($session);
    }
}
