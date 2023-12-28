<?php

declare(strict_types=1);

namespace Domain\Customer\DTO;

use Domain\Customer\Models\Customer;

final class PinCreateDTO
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
