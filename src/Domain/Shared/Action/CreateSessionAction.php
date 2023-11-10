<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;

final class CreateSessionAction
{
    public static function execute(
        array $request,
        ?string $state = null,
    ): Session {
        return Session::updateOrCreate([
            'session_id' => data_get(
                target: $request,
                key: 'SessionId',
            ),
        ], [
            'phone_number' => data_get(
                target: $request,
                key: 'Mobile',
            ),
            'sequence' => data_get(
                target: $request,
                key: 'Sequence',
            ),
            'state' => $state,
        ]);
    }
}
