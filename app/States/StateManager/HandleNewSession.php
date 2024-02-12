<?php

declare(strict_types=1);

namespace App\States\StateManager;

use App\States\Shared\WelcomeState;
use Domain\Shared\Action\Session\SessionCreateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HandleNewSession
{
    public static function execute($state_data): JsonResponse
    {
        // Execute the $session (WelcomeState)
        $session = SessionCreateAction::execute($state_data, state: 'WelcomeState');

        // Execute and return the WelcomeState
        return WelcomeState::execute(session: $session);
    }
}
