<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use App\Services\Customer\CustomerService;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StrictDebitAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['strict_debit' => $session_data->user_input]);

        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new CustomerService)->linkedAccount(customer: $customer);

        // Reformat the wallets
        $wallets = Helpers::formatLinkedWalletsInArray($linked_wallets['data']);
        SessionInputUpdateAction::data(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex($wallets)]);

        // Return the enterSusuAmountMenu
        return CreateFlexySusuMenu::linkedWalletMenu(session: $session, wallets: $linked_wallets);
    }
}
