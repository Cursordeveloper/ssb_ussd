<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\AboutLoans;

use App\Menus\ExistingCustomer\Loan\AboutLoans\AboutLoansMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutLoansState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return AboutLoansMenu::mainMenu(session: $session);
    }
}
