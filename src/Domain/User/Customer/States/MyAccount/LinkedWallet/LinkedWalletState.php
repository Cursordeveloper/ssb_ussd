<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount\LinkedWallet;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
