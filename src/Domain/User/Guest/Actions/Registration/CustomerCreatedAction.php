<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\User\Customer\Models\Customer;

final class CustomerCreatedAction
{
    public static function execute(array $request): bool
    {
        // Create the Customer
        $create_customer = Customer::query()->updateOrCreate(
            ['phone_number' => data_get(target: $request, key: 'data.attributes.phone_number')],
            [
                'resource_id' => data_get(target: $request, key: 'data.attributes.resource_id'),
                'first_name' => data_get(target: $request, key: 'data.attributes.first_name'),
                'last_name' => data_get(target: $request, key: 'data.attributes.last_name'),
                'phone_number' => data_get(target: $request, key: 'data.attributes.phone_number'),
                'accepted_terms' => data_get(target: $request, key: 'data.attributes.accepted_terms'),
                'status' => data_get(target: $request, key: 'data.attributes.status'),
            ]
        );

        return (bool) $create_customer;
    }
}
