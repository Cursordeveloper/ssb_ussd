<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Lock;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Lock\FlexySusuAccountLockMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountLockDurationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the durations
        $duration = json_decode($session->user_data, associative: true)['durations'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $duration)) {
            return FlexySusuAccountLockMenu::invalidDurationMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $duration[$session_data->user_input]['code']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
