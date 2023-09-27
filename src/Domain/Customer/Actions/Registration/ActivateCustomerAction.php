<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use Domain\Customer\Actions\Common\GetCustomerAction;

final class ActivateCustomerAction
{
    public static function execute(array $data): bool
    {
        // Get the customer with the resource_id
        $customer = GetCustomerAction::execute(
            data_get(
                target: $data,
                key: 'data.attributes.resource_id'
            )
        );

        // Update the customer status
        return $customer->update(['status' => 'active']);
    }
}
