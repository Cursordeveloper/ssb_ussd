<?php

declare(strict_types=1);

namespace App\Menus\Shared;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GeneralMenu
{
    public static function invalidInput($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "There was a problem with your request. Try again later.\n",
            session_id: $session->session_id,
        );
    }

    public static function infoNotification($session, string $message): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: $message,
            session_id: $session->session_id,
        );
    }

    public static function terminateSession($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::terminateSession(
            session_id: $session->session_id,
        );
    }

    public static function systemErrorNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "There was a problem. Try again later.\n",
            session_id: $session->session_id,
        );
    }

    public static function requestNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "Your request is being processed. You will receive a notification to confirm status.\n",
            session_id: $session->session_id,
        );
    }

    public static function createAccountNotification($session): JsonResponse
    {
        // Reset resetUserInputs and resetUserData
        SessionInputUpdateAction::resetAll(session: $session);

        return ResponseBuilder::infoResponseBuilder(
            message: "Your account is being processed. You will receive a notification to confirm status.\n",
            session_id: $session->session_id,
        );
    }
}
