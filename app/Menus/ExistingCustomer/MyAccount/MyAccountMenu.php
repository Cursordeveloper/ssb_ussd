<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "My Account\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\nMy Account\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Exit",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
