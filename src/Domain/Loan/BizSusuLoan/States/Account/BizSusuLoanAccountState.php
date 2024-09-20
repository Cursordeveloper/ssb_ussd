<?php

declare(strict_types=1);

namespace Domain\Loan\BizSusuLoan\States\Account;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuLoanAccountState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
