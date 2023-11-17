<?php

declare(strict_types=1);

namespace App\Menus\Account;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountMenu
{
    public static function accountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "My Account\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Exit",
            session_id: $session,
        );
    }
    public static function invalidAccountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n\nMy Account\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Exit",
            session_id: $session,
        );
    }
}
