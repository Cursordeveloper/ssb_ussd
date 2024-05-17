<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts;

use App\Common\Helpers;
use App\Common\SusuAccounts;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuServiceSususRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsAction
{
    public static function execute(Session $session): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $susus = (new SusuServiceSususRequest)->execute(customer: $customer);

        // Terminate session if $susu_collection request status is false
        if (data_get($susus, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($susus, key: 'data'))) {
            // Reformat the susu accounts
            $susu = SusuAccounts::formatSusuAccountsInArray(susu_collection: $susus['data']);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserData(session: $session, user_data: ['susu_accounts' => Helpers::arrayIndex(array: $susu)]);

            // Return the susuAccountsMenu
            return MySusuAccountsMenu::susuAccountsMenu(session: $session, susu_data: $susus);
        }

        // Return the noSususAccount
        return MySusuAccountsMenu::noSususAccount(session: $session);
    }
}
