<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class SessionUpdateAction
{
    public static function execute(
        Session $session,
        string $state,
    ): void {
        $session->update(['state' => $state]);
    }
}
