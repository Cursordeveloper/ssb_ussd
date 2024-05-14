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
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $start_dates = $user_data['start_dates'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $start_dates)) {
            return CreateGoalGetterSusuMenu::invalidStartDateMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['start_date' => $start_dates[$session_data->user_input]['code']]);

        // Return the enterSusuAmountMenu
        return CreateGoalGetterSusuMenu::frequencyMenu(session: $session);
    }
}
