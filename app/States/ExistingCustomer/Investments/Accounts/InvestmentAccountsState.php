<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\Accounts;

use App\Menus\ExistingCustomer\Investment\InvestmentMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return InvestmentMenu::mainMenu(session: $session);
    }
}
