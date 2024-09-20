<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Collection\Pause;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPauseDurationAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input (account_name)
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $session->userData()['durations']) => GeneralMenu::invalidDurationMenu(session: $session),

            default => self::durationStore(session: $session, service_data: $service_data)
        };
    }

    public static function durationStore(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $session->userData()['durations'][$service_data->user_input]['code']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
