<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Session;

use Domain\Shared\Models\Session\Session;

final class SessionGetAction
{
    public static function execute(string $session_id): Session
    {
        return Session::where(column: 'session_id', operator: '=', value: $session_id)->first();
    }
}
