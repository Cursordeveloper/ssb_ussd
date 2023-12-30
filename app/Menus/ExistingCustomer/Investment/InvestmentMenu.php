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
            message: "Investments\n1. My accounts\n2. Start investment\n3. Check balances\n4. About investments\n5. Investment terms\n6. Withdrawals\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nInvestments\n1. My accounts\n2. Start investment\n3. Check balances\n4. About investments\n5. Investment terms\n6. Withdrawals\n0. Back",
            session_id: $session->session_id,
        );
    }
}
