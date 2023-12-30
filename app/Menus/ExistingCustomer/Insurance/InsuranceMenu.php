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
            message: "Insurance\n1. My accounts\n2. Start insurance\n3. Check balance\n4. About insurance\n5. Insurance terms\n6. Make a claim\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nInsurance\n1. My accounts\n2. Start insurance\n3. Check balance\n4. About insurance\n5. Insurance terms\n6. Make a claim\n0. Back",
            session_id: $session->session_id,
        );
    }
}
