<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Investment;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, we got amazing investment products coming soon.',
            session_id: $session->session_id,
        );

        //        return ResponseBuilder::ussdResourcesResponseBuilder(
        //            message: "Investments\n1. Investment Menu 1\n2. Investment Menu 2\n3. Investment Menu 3\n0. Exit",
        //            session_id: $session->session_id,
        //        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nInvestments\n1. Investment Menu 1\n2. Investment Menu 2\n3. Investment Menu 3\n0. Exit",
            session_id: $session->session_id,
        );
    }
}
