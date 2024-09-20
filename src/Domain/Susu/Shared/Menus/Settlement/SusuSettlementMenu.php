<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\Settlement;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSettlementMenu
{
    public static function noPendingSettlementMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'You currently have no pending settlements. Please check back later or review your recent transactions for further details.',
            session_id: $session->session_id,
        );
    }

    public static function lowCurrentCycleMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'The current cycle cannot be less than 2. Please check back later or review your recent transactions for further details.',
            session_id: $session->session_id,
        );
    }

    public static function invalidConfirmationMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice.\nWould you like to proceed with the current action?\n1. Yes\n2. No",
            session_id: $session->session_id,
        );
    }

    public static function settlementLockedMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'The susu account is locked, and settlement has been suspended. Please wait for the account to be unlocked before proceeding.',
            session_id: $session->session_id,
        );
    }

    public static function settlementNotificationMenu($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Your settlement is being processed. You will receive a notification to confirm status',
            session_id: $session->session_id,
        );
    }
}
