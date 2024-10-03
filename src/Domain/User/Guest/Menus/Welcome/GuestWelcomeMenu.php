<?php

declare(strict_types=1);

namespace Domain\User\Guest\Menus\Welcome;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GuestWelcomeMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Register now\n2. About SusuBox\n3. Terms & Conditions\n0. Exit",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Register now\n2. About Susubox\n3. Terms & Conditions\n0. Exit",
            session_id: $session->session_id,
        );
    }
}
