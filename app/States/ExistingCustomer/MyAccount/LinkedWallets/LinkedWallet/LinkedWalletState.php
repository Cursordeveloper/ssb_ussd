<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
