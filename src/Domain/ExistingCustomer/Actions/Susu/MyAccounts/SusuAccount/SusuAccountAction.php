<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuServiceSusuRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountAction
{
    public static function execute(Session $session): JsonResponse
    {
        // Get the susu data
        $susu_data = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServiceSusuRequest HTTP request
        $susu = (new SusuServiceSusuRequest)->execute(
            customer: $customer,
            susu_resource: data_get(target: $susu_data, key: 'susu_account.resource_id'),
            scheme_code: data_get(target: $susu_data, key: 'susu_account.scheme_code')
        );

        // Terminate session if $susu_collection request status is false
        if (data_get($susu, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($susu, key: 'data'))) {
            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_account' => data_get(target: $susu, key: 'data')]);

            // Return the susuAccountsMenu
            return SusuAccountMenu::susuAccountMenu(session: $session, account_name: data_get(target: $susu, key: 'data.attributes.account_name'));
        }

        // Return the noSususAccount
        return MySusuAccountsMenu::noSususAccount(session: $session);
    }
}
