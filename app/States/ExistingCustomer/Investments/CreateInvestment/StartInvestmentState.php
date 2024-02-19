<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\CreateInvestment;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartInvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
