<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\Welcome;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerWelcomeMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Susu\n2. About SusuBox\n3. Terms and Conditions\n4. My Account\n0. Exit",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Susu\n2. About SusuBox\n3. Terms and Conditions\n4. My Account\n0. Exit",
            session_id: $session->session_id,
        );
    }

    public static function inactiveAccount(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Your account is inactive. Contact SusuBox customer support on 08000088 toll free for a feedback or reasons.',
            session_id: $session->session_id,
        );
    }
}
