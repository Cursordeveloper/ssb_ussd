<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\AboutSusu\SusuSchemes;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\AboutSusu\AboutSusuSchemesAction;
use Domain\Susu\Shared\Actions\AboutSusu\BackToAboutSusuAction;
use Domain\Susu\Shared\Menus\AboutSusu\SusuSchemes\AboutSusuSchemesMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuSchemesState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            $service_data->user_input === '#' => AboutSusuSchemesAction::execute(session: $session, service_data: $service_data),
            $service_data->user_input === '0' => self::exitExecution(session: $session, service_data: $service_data),

            default => AboutSusuSchemesMenu::invalidInputMenu(session: $session),
        };
    }

    private static function exitExecution(Session $session, $service_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        // Return the WelcomeState
        return BackToAboutSusuAction::execute(session: $session, service_data: $service_data);
    }
}
