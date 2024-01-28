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
            message: "Insurance\n1. My Insurance Accounts\n2. Start New Insurance\n3. About Insurance\n4. Insurance Terms\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Insurance Accounts\n2. Start New Insurance\n3. About Insurance\n4. Insurance Terms\n0. Back",
            session_id: $session->session_id,
        );
    }
}
