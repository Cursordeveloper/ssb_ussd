<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\Settlement;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SettlementState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the MyAccountMenu
        return GeneralMenu::infoNotification(
            message: 'Dear valued customer, susu settlement features coming soon.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
