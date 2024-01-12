<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment;

use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuPayment\SusuPaymentAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the SusuPaymentAction
        return SusuPaymentAction::execute(session: $session, session_data: $session_data);
    }
}
