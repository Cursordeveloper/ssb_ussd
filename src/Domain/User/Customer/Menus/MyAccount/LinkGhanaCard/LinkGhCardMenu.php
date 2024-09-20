<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyAccount\LinkGhanaCard;

use App\Common\ResponseBuilder;
use Domain\User\Customer\Actions\Common\HasLinkedGhanaCardAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkGhCardMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute and return enterIDMenu
        if (! HasLinkedGhanaCardAction::execute(session: $session)) {
            return self::enterIDMenu(session: $session);
        }

        // Terminate session if customer has Kyc
        return self::hasKycMenu(session: $session);
    }

    public static function enterIDMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Ghana Card number',
            session_id: $session->session_id,
        );
    }

    public static function noKycMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "You have not linked your Ghana Card to your Susubox account. Select option 3 on 'My Account' to link your Ghana Card.",
            session_id: $session->session_id,
        );
    }

    public static function hasKycMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You have already linked your Ghana Card.',
            session_id: $session->session_id,
        );
    }
}
