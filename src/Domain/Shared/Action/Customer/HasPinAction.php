<?php

declare(strict_types=1);

namespace Domain\Shared\Action\Customer;

final class HasPinAction
{
    public static function execute($session): bool
    {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Return true if customer is found and has pin
        if (data_get(target: $customer, key: 'status') === 'active' && $customer['has_pin'] !== true) {
            return true;
        }

        return false;
    }
}
