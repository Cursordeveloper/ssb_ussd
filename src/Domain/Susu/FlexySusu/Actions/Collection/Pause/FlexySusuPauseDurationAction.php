<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Collection\Pause;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Collection\Pause\FlexySusuCollectionPauseMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuPauseDurationAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the durations
        $duration = json_decode($session->user_data, associative: true)['durations'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $service_data->user_input, array: $duration)) {
            return FlexySusuCollectionPauseMenu::invalidDurationMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $duration[$service_data->user_input]['code']]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
