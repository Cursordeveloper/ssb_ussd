<?php

declare(strict_types=1);

namespace Domain\Loan\SwiftLoan\States\Payment;

use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SwiftLoanPaymentState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
    }
}
