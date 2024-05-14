<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkedWallets;

use App\Common\Helpers;
use App\Common\LinkedWallets;
use App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsMenu;
use App\Services\Susu\Requests\Customer\SusuServiceLinkAccountsRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsAction
{
    public static function execute(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new SusuServiceLinkAccountsRequest)->execute(customer: $customer);

        // Prepare and return the linked wallets
        if (! empty(data_get(target: $linked_wallets, key: 'data'))) {
            // Reformat the susu accounts
            $wallets = LinkedWallets::formatLinkedWalletsInArray($linked_wallets['data']);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserData(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex($wallets)]);

            // Return the susuAccountsMenu
            return LinkedWalletsMenu::linkedWalletCollectionMenu(session: $session, wallets: $linked_wallets);
        }

        // Return customer has no linked wallet
        return LinkedWalletsMenu::noLinkedWalletMenu($session);
    }
}
