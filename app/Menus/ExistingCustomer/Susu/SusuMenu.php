<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu\n1. My Accounts\n2. Create Susu\n3. Check Balance\n4. Manual Payment\n5. Settlements",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Accounts\n2. Create Susu\n3. Check Balance\n4. Manual Payment\n5. Settlements",
            session_id: $session->session_id,
        );
    }
}
