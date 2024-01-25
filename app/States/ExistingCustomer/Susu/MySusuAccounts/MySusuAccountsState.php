<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use Domain\ExistingCustomer\Actions\Common\ReturnToServiceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
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

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the SusuAccountState if user input is valid
        if (array_key_exists(key: $session_data->user_input, array: $user_data['susu_accounts'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_resource' => $user_data['susu_accounts'][$session_data->user_input]['resource_id']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $user_data['susu_accounts'][$session_data->user_input]['account_name']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_scheme' => $user_data['susu_accounts'][$session_data->user_input]['scheme']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_frequency' => $user_data['susu_accounts'][$session_data->user_input]['frequency']]);

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'SusuAccountState', session_data: $session_data);

            // Execute the SusuAccountState
            return SusuAccountMenu::mainMenu(session: $session);
        }

        // Execute MySusuAccountsAction action
        return MySusuAccountsMenu::invalidSusuAccountsMenu(session: $session, susu_data: $user_data['susu_accounts']);
    }
}
