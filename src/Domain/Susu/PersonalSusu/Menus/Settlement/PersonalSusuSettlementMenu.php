<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Settlements\n1. Settle Pending\n2. Settle All Pending\n3. Settle Everything\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Settle Pending\n2. Settle All Pending\n3. Settle Everything\n0. Back",
            session_id: $session->session_id,
        );
    }
}
