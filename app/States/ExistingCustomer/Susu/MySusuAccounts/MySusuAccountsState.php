<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts;

use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        if ($session_data->user_input === '0') {
            $susu_state = ['class' => new SusuState, 'menu' => new SusuMenu];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

            // Execute the state
            return $susu_state['menu']::mainMenu(session: $session);
        }

        // Execute MySusuAccountsAction action
        return MySusuAccountsAction::execute(session: $session, session_data: $session_data);
    }
}
