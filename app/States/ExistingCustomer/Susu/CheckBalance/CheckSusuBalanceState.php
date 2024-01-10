<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CheckBalance;

use Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\CheckBalance\CheckSusuBalanceAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CheckSusuBalanceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the CheckBalanceAction
        return CheckSusuBalanceAction::execute(session: $session, session_data: $session_data);
    }
}
