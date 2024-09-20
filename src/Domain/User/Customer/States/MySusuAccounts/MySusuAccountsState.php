<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MySusuAccounts;

use App\Common\Helpers;
use App\Services\Susu\Requests\Susu\SusuServiceSusuRequest;
use Domain\Shared\Action\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Return to the SusuState if user_input is (0)
        if ($service_data->user_input === '0') {
            return ReturnToServiceAction::execute(session: $session, service_data: $service_data, service: 'susu');
        }

        // Get the session->user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Return the invalidSusuAccountsMenu (if user_input does not exist)
        if (! array_key_exists(key: $service_data->user_input, array: data_get(target: $user_data, key: 'susu_accounts'))) {
            return MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data['susu_accounts']);
        }

        // Update the updateUserInputs with the [susu_account] option selected
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme_code' => $user_data['susu_accounts'][$service_data->user_input]['susu_scheme_code']]);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the susu_account from the SusuService
        $susu_account = (new SusuServiceSusuRequest)->execute(
            customer: $customer,
            susu_resource: $user_data['susu_accounts'][$service_data->user_input]['susu_resource'],
            scheme_code: $user_data['susu_accounts'][$service_data->user_input]['susu_scheme_code']
        );

        // Execute the following actions if (SusuServiceSusuRequest) is successful
        if (data_get($susu_account, key: 'code') === 200) {
            // Update the [user_input] with the [susu_account] option selected
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_account' => data_get($susu_account, key: 'data')]);

            // Build the SusuAccountMenu with the from the session->user_inputs
            $account_menu = Helpers::getSusuScheme(scheme_code: json_decode($session->user_inputs, associative: true)['scheme_code']);

            // Execute the (UpdateSessionStateAction) to update the state
            SessionStateUpdateAction::execute(session: $session, state: class_basename($account_menu['state']), service_data: $service_data);

            // Execute and return the [mainMenu] for the [susu_account] option selected
            return $account_menu['menu']::mainMenu(session: $session);
        }

        // Execute and return the [invalidSusuAccountsMenu] if customer selected option does not exist
        return MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data['susu_accounts']);
    }
}
