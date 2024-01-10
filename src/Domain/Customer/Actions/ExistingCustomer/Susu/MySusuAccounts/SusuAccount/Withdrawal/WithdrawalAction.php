<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Withdrawal;

use App\Menus\ExistingCustomer\Susu\Settlement\SettlementMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class WithdrawalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the noSususAccount
        return SettlementMenu::mainMenu(session: $session);
    }
}
