<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartDateAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Prepare the duration array
        $duration = ['1' => 'Today', '2' => 'Next Week', '3' => 'Two Weeks', '4' => 'Next Month'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $duration)) {
            return CreateGoalGetterSusuMenu::invalidStartDateMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['start_date' => $duration[$session_data->user_input]]);

        // Return the enterSusuAmountMenu
        return CreateGoalGetterSusuMenu::frequencyMenu(session: $session);
    }
}
