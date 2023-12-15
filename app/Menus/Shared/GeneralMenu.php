<?php

declare(strict_types=1);

namespace App\Menus\Shared;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GeneralMenu
{
    public static function invalidInput($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: $session,
        );
    }

    public static function infoNotification(string $message, string $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: $message,
            session_id: $session,
        );
    }
}
