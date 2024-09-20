<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateStartDateAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the start_dates
        $start_dates = json_decode($session->user_data, associative: true)['start_dates'];

        // Validate the user_input (susu_amount)
        return match (true) {
            ! array_key_exists(key: $service_data->user_input, array: $start_dates) => GeneralMenu::invalidStartDateMenu(session: $session),

            default => self::startDateStore(session: $session, service_data: $service_data, start_dates: $start_dates)
        };
    }

    public static function startDateStore(Session $session, $service_data, $start_dates): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['start_date' => $start_dates[$service_data->user_input]['code']]);

        // Return the frequencyMenu
        return GeneralMenu::frequencyMenu(session: $session);
    }
}
