<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\Common;

use Domain\User\Customer\Models\Customer;

class GetCustomerAction
{
    public static function execute(string $resource)
    {
        // Get and return the customer
        return Customer::where(column: 'phone_number', operator: '=', value: $resource)->first();
    }
}
