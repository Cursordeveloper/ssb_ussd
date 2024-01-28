<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Investment;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Investments\n1. My Investment Accounts\n2. Start New Investment\n3. About Investment\n4. Investment Terms\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Investment Accounts\n2. Start New Investment\n3. About Investment\n4. Investment Terms\n0. Back",
            session_id: $session->session_id,
        );
    }
}
