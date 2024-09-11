<?php

declare(strict_types=1);

namespace Domain\Investment\Shared\States\StartInvestment;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartInvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
