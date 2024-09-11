<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\Menus\Pension;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PensionMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Pensions\n1. My Pensions\n2. Start Pension\n3. About Pensions\n4. Pension Terms\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Pensions\n2. Start Pension\n3. About Pensions\n4. Pension Terms\n0. Back",
            session_id: $session->session_id,
        );
    }
}
