<?php

declare(strict_types=1);

namespace Domain\Loan\Shared\States\LoanTerms;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanTermsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
