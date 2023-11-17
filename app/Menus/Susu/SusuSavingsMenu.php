<?php

declare(strict_types=1);

namespace App\Menus\Susu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSavingsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu\n1. Susu Menu 1\n2. Susu Menu 2\n3. Susu Menu 3\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n\nSusu\n1. Susu Menu 1\n2. Susu Menu 2\n3. Susu Menu 3\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
