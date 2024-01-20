<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the account main menu
        return ResponseBuilder::infoResponseBuilder(
            message: $user_inputs['wallet_number']."\nLinked wallet features coming soon.\n0. Back",
            session_id: $session->session_id,
        );
    }
}
