<?php

namespace Domain\Shared\States\Welcome;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\HasPinAction;
use Domain\User\Customer\Actions\Common\IsActiveAction;
use Domain\User\Customer\Actions\Common\IsNotActiveAction;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Domain\User\Guest\Menus\Welcome\GuestWelcomeMenu;
use Domain\User\Guest\States\Registration\RegistrationState;
use Domain\User\Guest\States\Welcome\GuestWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WelcomeState
{
    public static function execute(Session $session): JsonResponse
    {
        // Execute the state which matches the true statements below
        $customerState = match (true) {
            IsNotActiveAction::execute(session: $session) => ['class' => new CustomerWelcomeState, 'menu' => (new CustomerWelcomeMenu)::inactiveAccount(session: $session)],
            HasPinAction::execute(session: $session) => ['class' => new RegistrationState, 'menu' => (new RegistrationMenu)::choosePin(session: $session)],
            IsActiveAction::execute(session: $session) => ['class' => new CustomerWelcomeState, 'menu' => (new CustomerWelcomeMenu)::mainMenu(session: $session)],

            default => ['class' => new GuestWelcomeState, 'menu' => (new GuestWelcomeMenu)::mainMenu(session: $session)],
        };

        // Update the session state
        SessionStateUpdateAction::execute(session: $session, state: class_basename($customerState['class']), service_data: $session);

        // Return the mainMenu for the state
        return $customerState['menu'];
    }
}
