<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TargetDurationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Prepare the duration array
        $duration = ['1' => 'One month', '2' => 'Three months', '3' => 'Six months', '4' => 'Nine months', '5' => 'One year'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $duration)) {
            return CreateGoalGetterSusuMenu::invalidDurationMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['duration' => $duration[$session_data->user_input]]);

        // Return the enterSusuAmountMenu
        return CreateGoalGetterSusuMenu::frequencyMenu(session: $session);
    }
}
