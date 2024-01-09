<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts;

use App\Menus\ExistingCustomer\Susu\SusuAccount\SusuAccountMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Customer\Actions\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MySusuAccountsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the SusuState if user input is (0)
        if ($session_data->user_input === '0') {
            $susu_state = ['class' => new SusuState, 'menu' => new SusuMenu];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

            SessionInputUpdateAction::resetUserData(session: $session);
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Return to the SusuState
            return $susu_state['menu']::mainMenu(session: $session);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the SusuAccountState if user input is valid
        if (array_key_exists(key: 'begin', array: $user_inputs) && array_key_exists(key: $session_data->user_input, array: $user_data['susu_accounts'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_resource' => $user_data['susu_accounts'][$session_data->user_input]['resource_id']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $user_data['susu_accounts'][$session_data->user_input]['account_name']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_scheme' => $user_data['susu_accounts'][$session_data->user_input]['scheme']]);

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'SusuAccountState', session_data: $session_data);

            // Execute the SusuAccountState
            return SusuAccountMenu::mainMenu(session: $session, session_data: $session_data);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['begin' => true]);

        // Execute MySusuAccountsAction action
        return MySusuAccountsAction::execute(session: $session, session_data: $session_data);
    }
}
