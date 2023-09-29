<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\Registration;

use Domain\Customer\Actions\Common\GetCustomerAction;

final class PinCreatedAction
{
    public static function execute(array $data): bool
    {
        // Get the customer with the resource_id
        $customer = GetCustomerAction::execute(
            resource: data_get(
                target: $data,
                key: 'data.included.customer.attributes.resource_id',
            )
        );

        // Update the customer status
        return $customer->update(['has_pin' => 'true']);
    }
}
