<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Session;

use Domain\Shared\Models\Session\Session;

final class SessionStateUpdateAction
{
    public static function execute(Session $session, string $state, $session_data = null): void
    {
        $session->update([
            'state' => $state,
            'sequence' => data_get(target: $session, key: 'sequence').'*'.$session_data->sequence,
        ]);
    }
}
