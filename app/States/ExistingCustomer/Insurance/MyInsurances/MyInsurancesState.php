<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance\MyInsurances;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyInsurancesState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
