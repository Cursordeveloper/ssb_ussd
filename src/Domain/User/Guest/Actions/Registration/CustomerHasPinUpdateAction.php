<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\User\Customer\Actions\Common\GetCustomerAction;

final class CustomerHasPinUpdateAction
{
    public static function execute(array $data): bool
    {
        // Get the customer with the resource_id
        $customer = GetCustomerAction::execute(resource: data_get(target: $data, key: 'data.attributes.phone_number'));

        // Update the customer status
        return $customer->update(['resource_id' => data_get(target: $data, key: 'data.attributes.resource_id'), 'has_pin' => true]);
    }
}
