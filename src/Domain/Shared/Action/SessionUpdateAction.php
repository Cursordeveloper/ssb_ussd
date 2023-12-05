<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class SessionUpdateAction
{
    public static function execute(Session $session, string $state, $session_data = null): void
    {
        $session->update([
            'state' => $state,
            'sequence' => data_get(target: $session, key: 'sequence')."*".$session_data->sequence,
        ]);
    }
}
