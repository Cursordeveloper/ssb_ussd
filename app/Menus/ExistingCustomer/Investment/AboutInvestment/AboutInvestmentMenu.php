<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Investment\AboutInvestment;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInvestmentMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Investment\n1. Investment Schemes\n2. Contributions\n3. Returns\n4. Withdrawals\n5 Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Investment Schemes\n2. Contributions\n3. Returns\n4. Withdrawals\n5 Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }
}
