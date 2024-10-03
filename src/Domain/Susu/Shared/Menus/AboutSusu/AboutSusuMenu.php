<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\AboutSusu;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Susu\n1. Susu Schemes\n2. Collections\n3. Withdrawals\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Susu Schemes\n2. Collections\n3. Withdrawals\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }
}
