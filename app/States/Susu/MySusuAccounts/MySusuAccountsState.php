<?php

declare(strict_types=1);

namespace App\States\Susu\MySusuAccounts;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the MyAccountMenu
        return GeneralMenu::infoNotification(
            message: 'Dear valued customer, my susu account features coming soon.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
