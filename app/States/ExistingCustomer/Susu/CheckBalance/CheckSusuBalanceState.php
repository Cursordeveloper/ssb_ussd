<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CheckBalance;

use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Customer\Actions\ExistingCustomer\Susu\CheckBalance\CheckSusuBalanceAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CheckSusuBalanceState
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

        // Execute CheckBalanceAction action
        return CheckSusuBalanceAction::execute(session: $session, session_data: $session_data);
    }
}
