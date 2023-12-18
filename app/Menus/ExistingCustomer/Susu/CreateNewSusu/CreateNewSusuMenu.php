<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Schemes\n1. Personal Susu Savings\n2. Biz Susu Savings\n3. Goal Getter Savings\n4. Flexy Susu Savings",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n\n1. Personal Susu Savings\n2. Biz Susu Savings\n3. Goal Getter Savings\n4. Flexy Susu Savings",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
