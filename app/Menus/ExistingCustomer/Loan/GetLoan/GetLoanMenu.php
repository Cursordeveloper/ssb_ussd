<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan\GetLoan;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "Loan Schemes\n1. Personal Susu Loan\n2. Biz Susu Loan\n3. ",
            session_id: $session->session_id,
        );
    }

    public static function notQualifiedMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "At the moment, you don't qualify for a loan. Keep using Susubox and check back regularly. Susubox will notify you when you qualify",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n0. Exit",
            session_id: $session->session_id,
        );
    }
}
