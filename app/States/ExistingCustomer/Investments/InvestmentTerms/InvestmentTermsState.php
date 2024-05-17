<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments\InvestmentTerms;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentTermsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
