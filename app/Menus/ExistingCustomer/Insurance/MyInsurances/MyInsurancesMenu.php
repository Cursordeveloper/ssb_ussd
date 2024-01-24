<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Insurance\MyInsurances;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyInsurancesMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active insurance(s).\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nYou do not have any active insurance(s).\n0. Back",
            session_id: $session->session_id,
        );
    }
}
