<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\MyLoans\MyLoan\LoanPayment;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
    }
}
