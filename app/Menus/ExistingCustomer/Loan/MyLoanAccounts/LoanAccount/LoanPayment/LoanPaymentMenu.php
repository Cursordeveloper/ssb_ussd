<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan\MyLoanAccounts\LoanAccount\LoanPayment;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanPaymentMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, contents coming soon.',
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\nLoans\n1. Loan Menu 1\n2. Loan Menu 2\n3. Loan Menu 3\n0. Exit",
            session_id: $session->session_id,
        );
    }
}
