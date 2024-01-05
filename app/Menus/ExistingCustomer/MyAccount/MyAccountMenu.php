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
            message: "My Account\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n1. Linked Wallets\n2. Link New Wallet\n3. Change Pin\n0. Back",
            session_id: $session->session_id,
        );
    }
}
