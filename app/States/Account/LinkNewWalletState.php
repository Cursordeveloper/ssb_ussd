<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkNewWalletState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Terminate the session
        return GeneralMenu::infoNotification(
            message: 'Dear valued customer, Link new wallet features coming soon.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
