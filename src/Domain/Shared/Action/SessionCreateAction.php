<?php

declare(strict_types=1);

namespace Domain\Shared\Action;

use Domain\Shared\Models\Session;
use Illuminate\Http\Request;

final class SessionCreateAction
{
    public static function execute($ussd_service, $state): Session
    {
        return Session::create([
            'session_id' => $ussd_service->session_id,
            'msisdn' => $ussd_service->msisdn,
            'phone_number' => phone($ussd_service->msisdn),
            'sequence' => $ussd_service->sequence,
            'state' => $state,
        ]);
    }
}
