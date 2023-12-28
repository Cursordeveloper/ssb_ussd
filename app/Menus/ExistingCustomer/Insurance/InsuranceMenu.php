<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Insurance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, we got amazing insurance products coming soon.',
            session_id: $session->session_id,
        );

        //        return ResponseBuilder::ussdResourcesResponseBuilder(
        //            message: "Insurance\n1. Insurance Menu 1\n2. Insurance Menu 2\n3. Insurance Menu 3",
        //            session_id: $session->session_id,
        //        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nInsurance\n1. Insurance Menu 1\n2. Insurance Menu 2\n3. Insurance Menu 3",
            session_id: $session->session_id,
        );
    }
}
