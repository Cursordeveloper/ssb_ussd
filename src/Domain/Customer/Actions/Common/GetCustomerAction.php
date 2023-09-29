<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Common;

use Domain\Customer\Models\Customer;

final class GetCustomerAction
{
    public static function execute(string $resource): Customer
    {
        return Customer::where(
            column: 'phone_number',
            operator: '=',
            value: $resource
        )->orWhere(
            column: 'resource_id',
            operator: '=',
            value: $resource
        )->first();
    }
}
