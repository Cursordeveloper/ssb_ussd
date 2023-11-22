<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsState
{
    public static function execute(
        Session $session,
        $session_data,
    ): JsonResponse {
        // Terminate the session
        return GeneralMenu::infoNotification(
            message: 'Dear valued customer, linked wallets features coming soon.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
