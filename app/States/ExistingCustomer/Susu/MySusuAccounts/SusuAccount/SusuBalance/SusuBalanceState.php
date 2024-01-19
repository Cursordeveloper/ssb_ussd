<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance;

use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance\SusuBalanceAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return SusuBalanceAction::execute(session: $session, session_data: $session_data);
    }
}
