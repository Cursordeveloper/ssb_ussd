<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Lock;

use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Carbon\Carbon;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuDurationsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountLockMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),
            default => self::durationMenu(session: $session)
        };
    }

    public static function withdrawalLockedMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the menu for the susu_scheme
        return ResponseBuilder::infoResponseBuilder(
            message: 'Withdrawals on this account has been locked on: '.data_get(target: $user_inputs, key: 'susu_account.included.account_lock.attributes.locked_at').'. Will be unlocked on: '.data_get(target: $user_inputs, key: 'susu_account.included.account_lock.attributes.unlocked_at'),
            session_id: $session->session_id,
        );
    }

    public static function durationMenu($session): JsonResponse
    {
        // Execute the duration
        (new GetSusuDurationsAction)::execute(session: $session);

        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        // Return the menu for the susu_scheme
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu($session): JsonResponse
    {
        // Get the durations from the session->user_data
        $durations = json_decode($session->user_data, associative: true);

        // Return the invalidDurationMenu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n".SusuResources::formatDurationsForMenu(durations: $durations['durations']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $response): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Lock date: '.Carbon::parse(data_get(target: $response, key: 'data.attributes.locked_at'))->isoFormat(format: 'MM/DD/YYYY').'. Resume date:'.Carbon::parse(data_get(target: $response, key: 'data.attributes.unlocked_at'))->isoFormat(format: 'MM/DD/YYYY').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
