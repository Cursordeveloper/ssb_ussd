<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MySusuAccounts;

use App\Common\Helpers;
use App\Services\Susu\Requests\Susu\SusuServiceSusuRequest;
use Domain\Shared\Action\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        return match (true) {
            $service_data->user_input === '0' => ReturnToServiceAction::execute(session: $session, service_data: $service_data, service: 'susu'),
            ! array_key_exists(key: $service_data->user_input, array: data_get(target: $session->userData(), key: 'susu_accounts')) => MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $session->userData()['susu_accounts']),

            default => self::actionExecution(session: $session, service_data: $service_data),
        };
    }

    private static function actionExecution(Session $session, $service_data): JsonResponse
    {
        // Update the updateUserInputs with the [susu_account] option selected
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme_code' => $session->userData()['susu_accounts'][$service_data->user_input]['susu_scheme_code']]);

        // Get the susu_account from the SusuService
        $response = (new SusuServiceSusuRequest)->execute(
            customer: $session->customer,
            susu_resource: $session->userData()['susu_accounts'][$service_data->user_input]['susu_resource'],
            scheme_code: $session->userData()['susu_accounts'][$service_data->user_input]['susu_scheme_code']
        );

        // Execute the following actions if (SusuServiceSusuRequest) is successful
        if (data_get($response, key: 'code') === 200) {
            // Update the [user_input] with the [susu_account] option selected
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_account' => data_get($response, key: 'data')]);

            // Build the SusuAccountMenu with the from the session->user_inputs
            $account_menu = Helpers::getSusuScheme(scheme_code: $session->userInputs()['scheme_code']);

            // Execute the (UpdateSessionStateAction) to update the state
            SessionStateUpdateAction::execute(session: $session, state: class_basename($account_menu['state']), service_data: $service_data);

            // Execute and return the [mainMenu] for the [susu_account] option selected
            return $account_menu['menu']::mainMenu(session: $session);
        }

        // Return the systemErrorNotification
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
