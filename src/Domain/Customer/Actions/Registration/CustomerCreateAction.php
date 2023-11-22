<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use Domain\Customer\Models\Customer;
use Illuminate\Support\Str;

final class CustomerCreateAction
{
    public static function execute(
        string $phone_number,
    ): bool {
        // Create the Customer
        $create_customer = Customer::query()->create([
            'resource_id' => Str::uuid(),
            'phone_number' => $phone_number,
        ]);

        return (bool) $create_customer;
    }
}
