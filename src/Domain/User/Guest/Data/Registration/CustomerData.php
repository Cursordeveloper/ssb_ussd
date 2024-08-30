<?php

declare(strict_types=1);

namespace Domain\User\Guest\Data\Registration;

use Domain\User\Customer\Models\Customer;

final class CustomerData
{
    public static function toArray(Customer $customer): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Customer',

                // Resource exposed attributes
                'attributes' => [
                    'resource_id' => $customer->resource_id,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'phone_number' => $customer->phone_number,
                    'accepted_terms' => true,
                    'status' => $customer->status,
                ],
            ],
        ];
    }
}
