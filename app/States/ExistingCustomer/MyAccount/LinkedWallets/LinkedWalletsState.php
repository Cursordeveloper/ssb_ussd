<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkedWallets;

use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use Domain\ExistingCustomer\Actions\MyAccount\LinkedWallets\LinkedWalletsAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // If the user_input is '0', return back to MyAccountMenu main menu
        if ($session_data->user_input === '0') {
            // Execute the SessionInputUpdateAction(reset)
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Execute the SessionInputUpdateAction(resetState)
            SessionInputUpdateAction::resetState(session: $session, state: 'MyAccountState');

            // Return the WelcomeState
            return MyAccountMenu::mainMenu(session: $session);
        }

        // Execute the LinkedWalletsAction
        return LinkedWalletsAction::execute(session: $session, session_data: $session_data);
    }
}
