<?php

namespace Domain\Shared\States;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\NewCustomer\NewCustomerMenu;
use App\Menus\NewCustomer\Registration\RegistrationMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\NewCustomer\NewCustomerState;
use App\States\NewCustomer\Registration\RegistrationState;
use Domain\Shared\Action\Customer\HasPinAction;
use Domain\Shared\Action\Customer\IsActiveAction;
use Domain\Shared\Action\Customer\IsNotActiveAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(Session $session): JsonResponse
    {
        // Define customer account status actions
        $isNotActive = IsNotActiveAction::execute(session: $session);
        $hasPin = HasPinAction::execute(session: $session);
        $isActive = IsActiveAction::execute(session: $session);

        // Execute the state which matches the true statements below
        $customerState = match (true) {
            $isNotActive => ['class' => new ExistingCustomerState, 'menu' => (new ExistingCustomerMenu)::inactiveAccount(session: $session)],
            $hasPin => ['class' => new RegistrationState, 'menu' => (new RegistrationMenu)::choosePin(session: $session)],
            $isActive => ['class' => new ExistingCustomerState, 'menu' => (new ExistingCustomerMenu)::mainMenu(session: $session)],

            default => ['class' => new NewCustomerState, 'menu' => (new NewCustomerMenu)::mainMenu(session: $session)],
        };

        // Update the session state
        UpdateSessionStateAction::execute(session: $session, state: class_basename($customerState['class']), session_data: $session);

        // Return the mainMenu for the state
        return $customerState['menu'];
    }
}
