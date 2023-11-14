<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;
use Illuminate\Http\Request;

final class SessionCreateAction
{
    public static function execute(
        Request $request,
        $state,
    ): Session {
        return Session::create([
            'session_id' => data_get(
                target: $request,
                key: 'SessionId',
            ),
            'msisdn' => data_get(
                target: $request,
                key: 'Mobile',
            ),'phone_number' => phone(
                data_get(target: $request, key: 'Mobile'),
            ),
            'sequence' => data_get(
                target: $request,
                key: 'Sequence',
            ),
            'state' => $state,
        ]);
    }
}
