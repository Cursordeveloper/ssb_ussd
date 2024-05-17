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
            message: "Loans\n1. My Loans\n2. Get a Loan\n3. About Loans\n4. Loan Terms\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. My Loans\n2. Get a Loan\n3. About Loans\n4. Loan Terms\n0. Back",
            session_id: $session->session_id,
        );
    }
}
