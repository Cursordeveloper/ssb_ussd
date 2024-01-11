<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuCollection;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $susu_collection = (new SusuCollection)->execute(customer: $customer);

        // Terminate session if $susu_collection request status is false
        if (! data_get($susu_collection, key: 'status') === true) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($susu_collection, key: 'data'))) {
            // Reformat the susu accounts
            $susu = Helpers::formatSusuAccountsInArray($susu_collection['data']);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserData(session: $session, user_data: ['susu_accounts' => Helpers::arrayIndex($susu)]);

            // Return the susuAccountsMenu
            return MySusuAccountsMenu::susuAccountsMenu(session: $session, susu_data: $susu_collection);
        }

        // Return the noSususAccount
        return MySusuAccountsMenu::noSususAccount(session: $session);
    }
}
