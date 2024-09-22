<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyAccount\LinkGhanaCard;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\HasLinkedGhanaCardAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhCardMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return match (true) {
            ! HasLinkedGhanaCardAction::execute(session: $session) => self::enterIDMenu(session: $session),
            default => self::hasKycMenu(session: $session)
        };
    }

    public static function enterIDMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Ghana Card number',
            session_id: $session->session_id,
        );
    }

    public static function noKycMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You have not linked your Ghana Card to your Susubox account. Select option 3 on My Account to link your Ghana Card.',
            session_id: $session->session_id,
        );
    }

    public static function hasKycMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You have already linked your Ghana Card.',
            session_id: $session->session_id,
        );
    }
}
