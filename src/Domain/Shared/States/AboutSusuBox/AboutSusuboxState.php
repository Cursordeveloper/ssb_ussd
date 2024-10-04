<?php

declare(strict_types=1);

namespace Domain\Shared\States\AboutSusuBox;

use Domain\Shared\Action\AboutSusuBox\AboutSusuBoxAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Welcome\WelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuboxState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            $service_data->user_input === '#' => AboutSusuBoxAction::execute(session: $session, service_data: $service_data),
            $service_data->user_input === '0' => self::exitExecution(session: $session),

            default => AboutSusuboxMenu::invalidInputMenu($session),
        };
    }

    private static function exitExecution(Session $session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return the WelcomeState
        return WelcomeState::execute(session: $session);
    }
}
