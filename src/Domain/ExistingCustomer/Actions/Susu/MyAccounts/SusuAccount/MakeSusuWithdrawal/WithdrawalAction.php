<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\MakeSusuWithdrawal;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SettlementMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WithdrawalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the noSususAccount
        return SettlementMenu::mainMenu(session: $session);
    }
}
