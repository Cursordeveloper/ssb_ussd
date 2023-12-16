<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkedWallets;

use App\Services\Customer\CustomerService;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Models\Session;

final class LinkedWalletsAction
{
    public static function execute(Session $session): string
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new CustomerService)->linkedAccount(customer: $customer);

        if (! empty(data_get(target: $linked_wallets, key: 'data'))) {
            return "My Linked Wallets\n1. 0244294960 - MTN\n2. 0244637602 - AirtelTigo";
        }

        return 'You have not linked any wallet to your susubox account.';
    }
}
