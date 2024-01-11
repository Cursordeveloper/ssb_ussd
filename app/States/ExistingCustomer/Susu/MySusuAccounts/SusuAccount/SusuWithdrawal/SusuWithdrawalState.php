<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return GeneralMenu::infoNotification(
            session: $session,
            message: 'Dear valued customer, susu settlement features coming soon.',
        );
    }
}
