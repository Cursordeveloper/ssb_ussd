<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Insurance\AboutInsurance;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
