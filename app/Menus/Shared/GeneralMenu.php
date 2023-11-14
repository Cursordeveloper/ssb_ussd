<?php

declare(strict_types=1);

namespace App\Menus\Shared;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GeneralMenu
{
    public static function invalidInput($session): JsonResponse
    {
        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: $session,
        );
    }

    public static function infoNotification($message, $session): JsonResponse
    {
        return ResponseBuilder::invalidResponseBuilder(
            message: $message,
            session_id: $session,
        );
    }
}
