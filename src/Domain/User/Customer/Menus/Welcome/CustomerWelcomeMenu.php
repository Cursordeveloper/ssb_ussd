<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\Welcome;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CustomerWelcomeMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Menu\n1. Susu\n2. Loans\n3. Investments\n4. Insurance\n5. Pensions\n6. About Susubox\n7. My Account",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nMenu\n1. Susu\n2. Loans\n3. Investments\n4. Insurance\n5. Pensions\n6. About Susubox\n7. My Account",
            session_id: $session->session_id,
        );
    }

    public static function inactiveAccount($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Your account is inactive. Contact Susubox customer support on 08000088 toll free for a feedback or reasons.',
            session_id: $session->session_id,
        );
    }
}
