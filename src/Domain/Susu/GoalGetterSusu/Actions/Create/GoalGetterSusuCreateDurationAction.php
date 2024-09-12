<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateDurationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the durations
        $duration = json_decode($session->user_data, associative: true)['durations'];

        // Validate the user_input (susu_amount)
        return match (true) {
            ! array_key_exists(key: $session_data->user_input, array: $duration) => GoalGetterSusuCreateMenu::invalidDurationMenu(session: $session),

            default => self::durationStore(session: $session, session_data: $session_data, duration: $duration)
        };
    }

    public static function durationStore(Session $session, $session_data, $duration): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $duration[$session_data->user_input]['code']]);

        // Return the enterSusuAmountMenu
        return GoalGetterSusuCreateMenu::startDateMenu(session: $session);
    }
}
