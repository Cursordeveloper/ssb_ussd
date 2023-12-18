<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSavingsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu\n1. My Susu Accounts\n2. Create Susu\n3. Settlements",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n1. My Susu Accounts\n2. Create Susu\n3. Settlements",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
