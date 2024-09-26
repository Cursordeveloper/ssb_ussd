<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Menus\Lock;

use App\Common\ResponseBuilder;
use Carbon\Carbon;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountLockMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),

            default => GeneralMenu::durationMenu(session: $session)
        };
    }

    public static function withdrawalLockedMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Withdrawals on this account has been locked on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_lock.attributes.locked_at').'. Will be unlocked on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_lock.attributes.unlocked_at'),
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
