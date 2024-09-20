<?php

declare(strict_types=1);

namespace Domain\Loan\PersonalSusuLoan\States\Account;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuLoanAccountState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
