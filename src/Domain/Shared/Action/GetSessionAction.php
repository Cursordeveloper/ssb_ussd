<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class GetSessionAction
{
    public static function execute(
        string $session_id,
    ) {
        return Session::where(
            column: 'session_id',
            operator: "=",
            value: $session_id,
        )->first();
    }
}
