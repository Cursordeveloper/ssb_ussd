<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkedWallets;

use App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsMenu;
use App\Services\Customer\CustomerService;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new CustomerService)->linkedAccount(customer: $customer);

        // Prepare and return the linked wallets
        if (! empty(data_get(target: $linked_wallets, key: 'data'))) {
            return LinkedWalletsMenu::linkedWalletCollectionMenu($session, $linked_wallets);
        }

        // Return customer has no linked wallet
        return LinkedWalletsMenu::noLinkedWalletMenu($session);
    }
}
