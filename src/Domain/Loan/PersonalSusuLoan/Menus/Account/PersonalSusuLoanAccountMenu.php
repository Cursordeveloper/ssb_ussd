<?php

declare(strict_types=1);

namespace Domain\Loan\PersonalSusuLoan\Menus\Account;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuLoanAccountMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "At the moment, you don't qualify for a loan. Keep using Susubox and check back regularly. Susubox will notify you when you qualify",
            session_id: $session->session_id,
        );
    }
}
