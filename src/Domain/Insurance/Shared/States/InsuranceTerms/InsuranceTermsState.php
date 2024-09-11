<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\InsuranceTerms;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InsuranceTermsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
