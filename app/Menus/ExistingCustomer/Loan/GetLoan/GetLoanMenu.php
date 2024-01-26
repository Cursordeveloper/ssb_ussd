<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan\GetLoan;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Loan Schemes\n1. Personal Susu Loan\n2. Biz Susu Loan\n3. Swift Credit",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Personal Susu Loan\n2. Biz Susu Loan\n3. Swift Credit",
            session_id: $session->session_id,
        );
    }
}
