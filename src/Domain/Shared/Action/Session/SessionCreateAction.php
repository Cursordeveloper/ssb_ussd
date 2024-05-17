<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Session;

use App\Common\Helpers;
use Domain\Shared\Models\Session\Session;

final class SessionCreateAction
{
    public static function execute($ussd_service, $state): Session
    {
        return Session::create([
            'session_id' => $ussd_service->session_id,
            'msisdn' => $ussd_service->msisdn,
            'phone_number' => Helpers::formatPhoneNumber($ussd_service->msisdn),
            'sequence' => $ussd_service->sequence,
            'user_inputs' => json_encode([]),
            'user_data' => json_encode([]),
            'state' => $state,
        ]);
    }
}
