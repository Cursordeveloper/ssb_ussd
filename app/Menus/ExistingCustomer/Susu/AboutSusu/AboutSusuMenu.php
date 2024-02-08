<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\AboutSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Susu\n1. Susu Schemes\n2. Collections\n3. Withdrawals\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Susu Schemes\n2. Collections\n3. Withdrawals\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }
}
