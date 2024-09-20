<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\StartInsurance;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartInsuranceState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
