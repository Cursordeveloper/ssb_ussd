<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Common;

use Domain\Customer\Models\Customer;

final class GetCustomerAction
{
    public static function execute(array $request): Customer
    {
        // Get the customer with the email id
        return Customer::where(
            column: 'email',
            operator: '=',
            value: data_get(
                target: $request,
                key: 'data.attributes.email'
            )
        )->first();
    }
}
