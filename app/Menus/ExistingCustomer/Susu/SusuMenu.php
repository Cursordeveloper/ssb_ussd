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
            message: "Susu\n1. My accounts\n2. Create susu\n3. Check balance\n4. Manual payment\n5. About susu\n6. Susu terms\n7. Settlements\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My accounts\n2. Create susu\n3. Check balance\n4. Manual payment\n5. About susu\n6. Susu terms\n7. Settlements\n0. Back",
            session_id: $session->session_id,
        );
    }
}
