<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Customer;

use Domain\Shared\Models\Customer\Customer;

class GetCustomerAction
{
    public static function execute(string $resource)
    {
        return Customer::where(
            column: 'phone_number',
            operator: '=',
            value: $resource,
        )->first();
    }
}
