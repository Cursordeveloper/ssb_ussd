<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Loan\GetLoan\PersonalSusuLoan;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuLoanMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "At the moment, you don't qualify for a loan. Keep using Susubox and check back regularly. Susubox will notify you when you qualify",
            session_id: $session->session_id,
        );
    }
}
