<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu;

use App\Common\Helpers;
use App\Common\LinkedWallets;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use App\Services\Customer\Requests\LinkAccountsRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Frequency array
        $frequencies = ['1' => 'Daily', '2' => 'Weekly', '3' => 'Monthly'];

        // Check if user_input is in the $frequencies array
        if (! array_key_exists(key: $session_data->user_input, array: $frequencies)) {
            // return the invalid frequencyMenu
            return CreateBizSusuMenu::invalidFrequencyMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]]);

        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new LinkAccountsRequest)->execute(customer: $customer);

        // Reformat the wallets
        $wallets = LinkedWallets::formatLinkedWalletsInArray($linked_wallets['data']);
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex($wallets)]);

        // Return the chooseLinkedWalletMenu
        return CreateBizSusuMenu::linkedWalletMenu(session: $session, wallets: $linked_wallets);
    }
}
