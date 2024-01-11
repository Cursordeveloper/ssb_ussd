<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Data\Registration;

use Domain\Shared\Models\Customer\Customer;

final class CustomerData
{
    public static function toArray(Customer $customer): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Customer',
                'id' => data_get(
                    target: $customer,
                    key: 'id'
                ),

                // Resource exposed attributes
                'attributes' => [
                    'resource_id' => data_get(
                        target: $customer,
                        key: 'resource_id'
                    ),
                    'first_name' => data_get(
                        target: $customer,
                        key: 'first_name'
                    ),
                    'last_name' => data_get(
                        target: $customer,
                        key: 'last_name'
                    ),
                    'phone_number' => data_get(
                        target: $customer,
                        key: 'phone_number'
                    ),
                    'status' => data_get(
                        target: $customer,
                        key: 'status'
                    ),
                ],
            ],
        ];
    }
}
