<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Collection;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Collections\n1. Collection Summary\n2. Pause Collection\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Collection Summary\n2. Pause Collection\n0. Back",
            session_id: $session->session_id,
        );
    }
}
