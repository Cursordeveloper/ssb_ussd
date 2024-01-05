<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Insurance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Insurance\n1. My Accounts\n2. Start Insurance\n3. Check Balance\n4. About Insurance\n5. Insurance Terms\n6. Make Claim\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Accounts\n2. Start Insurance\n3. Check Balance\n4. About Insurance\n5. Insurance Terms\n6. Make Claim\n0. Back",
            session_id: $session->session_id,
        );
    }
}
