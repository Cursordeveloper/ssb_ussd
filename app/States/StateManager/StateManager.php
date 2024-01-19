<?php

declare(strict_types=1);

namespace App\States\StateManager;

use Domain\Shared\Action\Session\SessionGetAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StateManager
{
    public static function execute($state_data): JsonResponse
    {
        // Execute the HandleNewSession (If session is new)
        if ($state_data->new_session) {
            return HandleNewSession::execute(state_data: $state_data);
        }

        // Get the existing session data
        $session = SessionGetAction::execute(session_id: $state_data->session_id);
        $customer_session = data_get(target: $session, key: 'state');

        // Execute the ExecuteState
        return ExecuteState::execute($customer_session, $session, $state_data);
    }
}
