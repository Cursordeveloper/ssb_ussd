<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Customer;

final class IsNotActiveAction
{
    public static function execute($session): bool
    {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Return true if customer is found and is not (active)
        if ($customer && data_get(target: $customer, key: 'status') !== 'active') {
            return true;
        }

        return false;
    }
}
