<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Collection\Pause;

use App\Common\ResponseBuilder;
use Carbon\Carbon;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionPauseMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.collection_status') === 'paused' => self::collectionPausedMenu(session: $session),
            default => GeneralMenu::durationMenu(session: $session)
        };
    }

    public static function collectionPausedMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Collections on this account has been paused on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_pause.attributes.paused_at').'. Resume on: '.data_get(target: $session->userInputs(), key: 'susu_account.included.account_pause.attributes.resumed_at'),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $response): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Pause date: '.Carbon::parse(data_get(target: $response, key: 'data.attributes.paused_at'))->isoFormat(format: 'MM/DD/YYYY').'. Resume date:'.Carbon::parse(data_get(target: $response, key: 'data.attributes.resumed_at'))->isoFormat(format: 'MM/DD/YYYY').'. Enter PIN to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
