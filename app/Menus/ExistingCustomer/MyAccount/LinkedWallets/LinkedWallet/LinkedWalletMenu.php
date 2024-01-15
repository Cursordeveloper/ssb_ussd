<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Dear valued customer, contents coming soon.',
            session_id: $session->session_id,
        );
    }
}
