<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountState
{
    public static function execute(
        Session $session,
        Request $request,
    ): JsonResponse {
        // Terminate the session
        return GeneralMenu::infoNotification(
            message: 'Dear valued customer, the account features are being worked on. Try again later.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
