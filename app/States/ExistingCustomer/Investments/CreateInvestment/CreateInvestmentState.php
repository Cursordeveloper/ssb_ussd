<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\CreateInvestment;

use App\Menus\ExistingCustomer\Investment\MyInvestments\MyInvestmentsMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateInvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return MyInvestmentsMenu::mainMenu(session: $session);
    }
}
