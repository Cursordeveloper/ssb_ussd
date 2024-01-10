<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\MakePayment;

use App\Menus\ExistingCustomer\Susu\ManualSusuPaymentMenu\ManualSusuPaymentMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuWithScheme;
use Domain\Customer\Models\Customer;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SelectSusuAccountAction
{
    public static function execute(Session $session, Customer $customer, $session_data): JsonResponse
    {
        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Get susu resource_id and code with user input
        $susu_resource_id = $user_data['susu_accounts'][$session_data->user_input]['resource_id'];
        $susu_scheme_code = $user_data['susu_accounts'][$session_data->user_input]['scheme'];

        // Update the user inputs (steps)
        //        SessionInputUpdateAction::execute(session: $session, user_input: ['susu_account' => $susu_resource_id]);

        // Execute the createPersonalSusu HTTP request
        $susu_resource = (new SusuWithScheme)->execute(customer: $customer, susu_resource: $susu_resource_id, scheme: $susu_scheme_code);

        // Terminate session if $susu_collection request status is false
        if (! data_get(target: $susu_resource, key: 'status') === true || data_get(target: $susu_resource, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($susu_resource, key: 'data'))) {
            // Return the susuBalanceMenu
            return ManualSusuPaymentMenu::totalValueMenu(session: $session, frequency: data_get(target: $susu_resource, key: 'data.attributes.frequency'));
        }

        // Return the noSususAccount
        return ManualSusuPaymentMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data);
    }
}
