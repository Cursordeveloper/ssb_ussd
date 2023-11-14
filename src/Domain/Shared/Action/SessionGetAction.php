<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class SessionGetAction
{
    public static function execute(
        string $session_id,
    ): Session {
        return Session::where(
            column: 'session_id',
            operator: '=',
            value: $session_id,
        )->first();
    }
}
