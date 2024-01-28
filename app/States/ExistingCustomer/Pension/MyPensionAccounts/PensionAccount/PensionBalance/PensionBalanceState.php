<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Pension\MyPensionAccounts\PensionAccount\PensionBalance;

use App\Menus\ExistingCustomer\Insurance\InsuranceMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PensionBalanceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return InsuranceMenu::mainMenu(session: $session);
    }
}
