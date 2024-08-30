<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\Common;

final class IsActiveAction
{
    public static function execute($session): bool
    {
        // Get the customer
        $customer = GetCustomerAction::execute(data_get(target: $session, key: 'phone_number'));

        // Return true if customer is found and is (active)
        if ($customer && $customer->status === 'active') {
            return true;
        }

        // Return false
        return false;
    }
}
