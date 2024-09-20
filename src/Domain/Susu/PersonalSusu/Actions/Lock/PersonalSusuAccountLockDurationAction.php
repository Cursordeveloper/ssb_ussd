<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Lock;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Lock\PersonalSusuAccountLockMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountLockDurationAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the durations
        $duration = json_decode($session->user_data, associative: true)['durations'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $service_data->user_input, array: $duration)) {
            return PersonalSusuAccountLockMenu::invalidDurationMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $duration[$service_data->user_input]['code']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
