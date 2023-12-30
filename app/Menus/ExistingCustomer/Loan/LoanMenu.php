<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Loans\n1. Get a loan\n2. Loan repayment\n3. Check balance\n4. About loans\n5. Loan terms\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nLoans\n1. Get a loan\n2. Loan repayment\n3. Check balance\n4. About loans\n5. Loan terms\n0. Back",
            session_id: $session->session_id,
        );
    }
}
