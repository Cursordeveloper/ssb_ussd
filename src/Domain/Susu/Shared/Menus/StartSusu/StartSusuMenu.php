<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\StartSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Schemes\n1. Personal Susu\n2. Biz Susu\n3. Goal Getter Susu\n4. Flexy Susu",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Personal Susu\n2. Biz Susu\n3. Goal Getter Susu\n4. Flexy Susu",
            session_id: $session->session_id,
        );
    }
}
