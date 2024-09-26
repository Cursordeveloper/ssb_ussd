<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Lock;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountLockDurationAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $session->userData()['durations']) => GeneralMenu::invalidDurationMenu(session: $session),

            default => self::stateExecution(session: $session, service_data: $service_data),
        };
    }

    private static function stateExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $session->userData()['durations'][$service_data->user_input]['code']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
