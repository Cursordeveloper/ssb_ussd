<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use App\Services\Customer\Requests\LinkAccountsRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new LinkAccountsRequest)->execute(customer: $customer);

        // Reformat the wallets
        $wallets = Helpers::formatLinkedWalletsInArray($linked_wallets['data']);
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex($wallets)]);

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_amount' => $session_data->user_input]);

        // Return the chooseLinkedWalletMenu
        return CreatePersonalSusuMenu::linkedWalletMenu(session: $session, wallets: $linked_wallets);
    }
}
