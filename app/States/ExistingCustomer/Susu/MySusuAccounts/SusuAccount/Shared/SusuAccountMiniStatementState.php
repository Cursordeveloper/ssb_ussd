<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared;

use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuMiniStatement\SusuMiniStatementAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountMiniStatementState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return SusuMiniStatementAction::execute(session: $session, session_data: $session_data);
    }
}
