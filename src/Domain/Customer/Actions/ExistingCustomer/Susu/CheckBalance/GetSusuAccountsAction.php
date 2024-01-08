<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CheckBalance;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\CheckBalance\CheckBalanceMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuCollection;
use Domain\Customer\Models\Customer;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetSusuAccountsAction
{
    public static function execute(Session $session, Customer $customer, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['begin' => true]);

        // Execute the createPersonalSusu HTTP request
        $susu_collection = (new SusuCollection)->execute(customer: $customer);

        // Terminate session if $susu_collection request status is false
        if (! data_get(target: $susu_collection, key: 'status') === true || data_get(target: $susu_collection, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($susu_collection, key: 'data'))) {
            // Reformat the susu accounts
            $susu = Helpers::formatSusuAccountsInArray($susu_collection['data']);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserData(session: $session, user_data: ['susu_accounts' => Helpers::arrayIndex($susu)]);

            // Return the susuAccountsMenu
            return CheckBalanceMenu::susuAccountsMenu(session: $session, susu_data: $susu_collection);
        }

        // Return the noSususAccount
        return CheckBalanceMenu::noSususAccount(session: $session);
    }
}
