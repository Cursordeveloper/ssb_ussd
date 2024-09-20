<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Session;

use App\Common\Helpers;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;

final class SessionCreateAction
{
    public static function execute($ussd_service, $state): Session
    {
        $phone_number = Helpers::formatPhoneNumber($ussd_service->msisdn);

        return Session::create([
            'customer_id' => self::customerGet(phone_number: $phone_number),
            'session_id' => $ussd_service->session_id,
            'msisdn' => $ussd_service->msisdn,
            'phone_number' => Helpers::formatPhoneNumber($ussd_service->msisdn),
            'sequence' => $ussd_service->sequence,
            'user_inputs' => json_encode([]),
            'user_data' => json_encode([]),
            'state' => $state,
        ]);
    }

    public static function customerGet(string $phone_number)
    {
        $customer = GetCustomerAction::execute($phone_number);
        return $customer ? $customer->id : null;
    }
}
