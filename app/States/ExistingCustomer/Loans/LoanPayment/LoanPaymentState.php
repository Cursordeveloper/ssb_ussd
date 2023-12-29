<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Loans\LoanPayment;

use App\Menus\ExistingCustomer\Loan\ManualPayment\ManualLoanPaymentMenu;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoanPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return ManualLoanPaymentMenu::mainMenu(session: $session);
    }
}
