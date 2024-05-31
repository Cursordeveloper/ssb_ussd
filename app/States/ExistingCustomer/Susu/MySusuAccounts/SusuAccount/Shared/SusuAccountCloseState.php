<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared;

use Domain\Shared\Models\Session\Session;

final class SusuAccountCloseState
{
    public static function execute(Session $session, $session_data): void
    {
    }
}
