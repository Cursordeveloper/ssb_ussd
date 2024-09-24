<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Lock;

use App\Common\ResponseBuilder;
use App\Common\SusuResources;
use Carbon\Carbon;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Actions\Common\GetSusuDurationsAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountLockMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.settlement_status') === 'locked' => self::settlementLockedMenu(session: $session),
            default => self::durationMenu(session: $session)
        };
    }

    public static function settlementLockedMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Settlements on this account has been locked on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_lock.attributes.locked_at').'. Will be unlocked on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_lock.attributes.unlocked_at'),
            session_id: $session->session_id,
        );
    }

    public static function durationMenu(Session $session): JsonResponse
    {
        // Execute the duration
        (new GetSusuDurationsAction)::execute(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n".SusuResources::formatDurationsForMenu(durations: $session->userData()['durations']),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $response): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Lock date: '.Carbon::parse(data_get(target: $response, key: 'data.attributes.locked_at'))->isoFormat(format: 'MM/DD/YYYY').'. Resume date:'.Carbon::parse(data_get(target: $response, key: 'data.attributes.unlocked_at'))->isoFormat(format: 'MM/DD/YYYY').'. Enter PIN to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
