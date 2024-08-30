<?php

declare(strict_types=1);

namespace Domain\Shared\Services;

use Domain\Shared\Action\Session\SessionCreateAction;
use Domain\Shared\States\Welcome\WelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartNewSessionService
{
    public static function execute($state_data): JsonResponse
    {
        // Execute the $session (WelcomeState)
        $session = SessionCreateAction::execute($state_data, state: 'WelcomeState');

        // Execute and return the WelcomeState
        return WelcomeState::execute(session: $session);
    }
}
