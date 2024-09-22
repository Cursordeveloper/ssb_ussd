<?php

declare(strict_types=1);

namespace Domain\User\Customer\Menus\MyAccount\LinkedWallet;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::infoResponseBuilder(
            message: $session->userInputs()['wallet_number']."\nLinked wallet features coming soon.\n0. Back",
            session_id: $session->session_id,
        );
    }
}
