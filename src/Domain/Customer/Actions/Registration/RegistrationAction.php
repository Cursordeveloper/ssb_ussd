<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use Domain\Customer\Models\Customer;

final class RegistrationAction
{
    public static function execute(
        array $request
    ): Customer {
        // Create the customer
        return Customer::create([
            'first_name' => data_get(
                target: $request,
                key: 'data.attributes.first_name',
            ),
            'last_name' => data_get(
                target: $request,
                key: 'data.attributes.last_name',
            ),
            'phone_number' => data_get(
                target: $request,
                key: 'data.attributes.phone_number'
            ),
        ]);
    }
}
