<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Menus\Collection;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCollectionMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Collections\n1. Collection Summary\n2. Goal Summary\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Collection Summary\n2. Goal Summary\n0. Back",
            session_id: $session->session_id,
        );
    }
}
