<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\GetLoan;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetLoanState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
