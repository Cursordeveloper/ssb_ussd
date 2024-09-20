<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Enums\Product\CustomerStatus;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CustomerCreateAction
{
    public static function execute(Session $session): Customer
    {
        // Create and return the customer customer
        return DB::transaction(function () use ($session) {
            return Customer::create([
                'resource_id' => Str::uuid()->toString(),
                'phone_number' => $session->phone_number,
                'first_name' => $session->userInputs()['first_name'],
                'last_name' => $session->userInputs()['last_name'],
                'accepted_terms' => true,
                'status' => CustomerStatus::Active->value,
            ]);
        });
    }
}
