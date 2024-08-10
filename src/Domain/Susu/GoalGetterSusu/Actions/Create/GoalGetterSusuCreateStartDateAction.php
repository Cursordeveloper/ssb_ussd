<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateStartDateAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the start_dates
        $start_dates = json_decode($session->user_data, associative: true)['start_dates'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $start_dates)) {
            return GoalGetterSusuCreateMenu::invalidStartDateMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['start_date' => $start_dates[$session_data->user_input]['code']]);

        // Return the enterSusuAmountMenu
        return GoalGetterSusuCreateMenu::frequencyMenu(session: $session);
    }
}
