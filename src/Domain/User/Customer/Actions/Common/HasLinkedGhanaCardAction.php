<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\Common;

use App\Services\Customer\Requests\Kyc\GetKYCRequest;
use Domain\Shared\Models\Session\Session;

final class HasLinkedGhanaCardAction
{
    public static function execute(Session $session): bool
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Execute GetKYCRequest
        $kyc = (new GetKYCRequest)->execute(customer: $customer);

        // Return true if $kyc is not empty
        if (! empty(data_get(target: $kyc, key: 'data'))) {
            return true;
        }

        // Return false
        return false;
    }
}
