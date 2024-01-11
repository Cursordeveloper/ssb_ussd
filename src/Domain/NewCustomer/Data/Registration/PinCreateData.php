<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Data\Registration;

use Domain\Shared\Models\Customer\Customer;

final class PinCreateData
{
    public static function toArray(Customer $customer, string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Pin',

                // Resource exposed attributes
                'attributes' => [
                    'phone_number' => data_get(target: $customer, key: 'phone_number'),
                    'pin' => $pin,
                ],
            ],
        ];
    }
}
