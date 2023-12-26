<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\Settlement;

use App\Menus\ExistingCustomer\Susu\Settlement\SettlementMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SettlementAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the noSususAccount
        return SettlementMenu::mainMenu(session: $session);
    }
}
