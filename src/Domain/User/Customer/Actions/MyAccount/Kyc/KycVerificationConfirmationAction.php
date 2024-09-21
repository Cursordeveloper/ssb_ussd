<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\Kyc;

use Domain\User\Customer\Models\Customer;

final class KycVerificationConfirmationAction
{
    public static function execute(Customer $customer, array $request): void
    {
        // Update the customer [has_kyc] to true
        $customer->update(attributes: ['has_kyc' => true]);
    }
}
