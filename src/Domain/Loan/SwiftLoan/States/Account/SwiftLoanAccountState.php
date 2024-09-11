<?php

declare(strict_types=1);

namespace Domain\Loan\SwiftLoan\States\Account;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SwiftLoanAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
