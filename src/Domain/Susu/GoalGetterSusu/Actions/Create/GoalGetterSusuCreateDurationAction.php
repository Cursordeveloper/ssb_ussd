<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateDurationAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $session->userData()['durations']) => GeneralMenu::invalidDurationMenu(session: $session),

            default => self::actionExecution(session: $session, service_data: $service_data, duration: $session->userData()['durations'])
        };
    }

    public static function actionExecution(Session $session, $service_data, $duration): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['duration' => $duration[$service_data->user_input]['code']]);

        // Return the enterSusuAmountMenu
        return GeneralMenu::startDateMenu(session: $session);
    }
}
