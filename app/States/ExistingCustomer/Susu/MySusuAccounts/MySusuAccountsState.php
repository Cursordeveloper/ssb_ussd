<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts;

use App\Common\Helpers;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Services\Susu\Requests\Susu\SusuServiceSusuRequest;
use Domain\ExistingCustomer\Actions\Common\ReturnToServiceAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the SusuState if user input is (0)
        if ($session_data->user_input === '0') {
            return ReturnToServiceAction::execute(session: $session, session_data: $session_data, service: 'susu');
        }

        // Get the [user_data] from the [Session] class
        $user_data = json_decode($session->user_data, associative: true);

        // Return the invalidSusuAccountsMenu (if account option selected does not exist)
        if (! array_key_exists(key: $session_data->user_input, array: data_get(target: $user_data, key: 'susu_accounts'))) {
            return MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data['susu_accounts']);
        }

        // Update the updateUserInputs with the [susu_account] option selected
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme_code' => $user_data['susu_accounts'][$session_data->user_input]['susu_scheme_code']]);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the susu_account from the SusuService
        $susu_account = (new SusuServiceSusuRequest)->execute(
            customer: $customer,
            susu_resource: $user_data['susu_accounts'][$session_data->user_input]['susu_resource'],
            scheme_code: $user_data['susu_accounts'][$session_data->user_input]['susu_scheme_code']
        );

        // Execute the following actions if (SusuServiceSusuRequest) is successful
        if (data_get($susu_account, key: 'code') === 200) {
            // Update the [user_input] with the [susu_account] option selected
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_account' => data_get($susu_account, key: 'data.attributes')]);

            // Get the [user_input] from the [Session] class
            // Get the [state and menu] with the [user_input]
            $user_input = json_decode($session->user_inputs, associative: true);
            $account_menu = Helpers::getSusuScheme(scheme_code: data_get(target: $user_input, key: 'scheme_code'));

            // Execute the (UpdateSessionStateAction) to update the state
            UpdateSessionStateAction::execute(session: $session, state: class_basename($account_menu['state']), session_data: $session_data);

            // Execute and return the [mainMenu] for the [susu_account] option selected
            return $account_menu['menu']::mainMenu(session: $session);
        }

        // Execute and return the [invalidSusuAccountsMenu] if customer selected option does not exist
        return MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data['susu_accounts']);
    }
}
