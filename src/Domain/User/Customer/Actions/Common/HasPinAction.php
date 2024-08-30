<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\Common;

final class HasPinAction
{
    public static function execute($session): bool
    {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Return true if customer is found and (has_pin) is not true
        if ($customer && $customer->has_pin !== true) {
            return true;
        }

        // Return false
        return false;
    }
}
