<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use App\Services\Customer\CustomerService;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
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
        SessionInputUpdateAction::execute(session: $session, user_input: ['frequency' => $frequencies[$session_data->user_input]]);

        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new CustomerService)->linkedAccount(customer: $customer);

        // Reformat the wallets
        $wallets = Helpers::formatLinkedWalletsInArray($linked_wallets['data']);
        SessionInputUpdateAction::data(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex($wallets)]);

        // Return the chooseLinkedWalletMenu
        return CreateBizSusuMenu::linkedWalletMenu(session: $session, wallets: $linked_wallets);
    }
}
