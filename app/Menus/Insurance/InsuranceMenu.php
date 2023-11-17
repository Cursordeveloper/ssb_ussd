<?php

declare(strict_types=1);

namespace App\Menus\Insurance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Insurance\n1. Insurance Menu 1\n2. Insurance Menu 2\n3. Insurance Menu 3\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n\nInsurance\n1. Insurance Menu 1\n2. Insurance Menu 2\n3. Insurance Menu 3\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
