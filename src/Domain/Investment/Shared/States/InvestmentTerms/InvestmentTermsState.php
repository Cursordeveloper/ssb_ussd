<?php

declare(strict_types=1);

namespace Domain\Investment\Shared\States\InvestmentTerms;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentTermsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
