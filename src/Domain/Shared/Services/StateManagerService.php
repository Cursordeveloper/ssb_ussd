<?php

declare(strict_types=1);

namespace Domain\Shared\Services;

use Domain\Shared\Action\Session\SessionGetAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StateManagerService
{
    public static function execute($state_data): JsonResponse
    {
        // Execute the HandleNewSession (If session is new)
        if ($state_data->new_session) {
            return StartNewSessionService::execute(state_data: $state_data);
        }

        // Get the existing session data
        $session = SessionGetAction::execute(session_id: $state_data->session_id);
        $customer_session = data_get(target: $session, key: 'state');

        // Execute the ExecuteStateService
        return ExecuteStateService::execute($customer_session, $session, $state_data);
    }
}
