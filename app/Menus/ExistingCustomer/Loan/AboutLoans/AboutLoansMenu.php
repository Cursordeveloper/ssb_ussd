<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan\AboutLoans;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutLoansMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "About Loans\n1. Loan Schemes\n2. Loan Qualification\n3. Loan Payment & Repayment\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Loan Schemes\n2. Loan Qualification\n3. Loan Payment & Repayment\n4. Fees & Charges\n0. Back",
            session_id: $session->session_id,
        );
    }
}
