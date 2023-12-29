<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\GetLoan;

use App\Menus\ExistingCustomer\Loan\GetLoan\GetLoanMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return GetLoanMenu::mainMenu(session: $session);
    }
}
