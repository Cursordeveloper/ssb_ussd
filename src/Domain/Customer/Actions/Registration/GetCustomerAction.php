<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use Domain\Customer\Models\Customer;

final class GetCustomerAction
{
    public static function execute(string $resource): Customer
    {
        return Customer::where(
            'resource_id', '=', $resource
        )->first();
    }
}
