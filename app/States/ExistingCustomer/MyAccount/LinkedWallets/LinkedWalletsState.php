<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkedWallets;

use App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet\LinkedWalletMenu;
use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use Domain\ExistingCustomer\Actions\MyAccount\LinkedWallets\LinkedWalletsAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return back to MyAccountMenu if user_input is (0)
        if ($session_data->user_input === '0') {
            // Execute the SessionInputUpdateAction(reset)
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Execute the SessionInputUpdateAction(resetState)
            SessionInputUpdateAction::resetState(session: $session, state: 'MyAccountState');

            // Return the WelcomeState
            return MyAccountMenu::mainMenu(session: $session);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the LinkedWallet if user input is valid
        if (array_key_exists(key: 'Linked_wallets_state', array: $user_inputs) && array_key_exists(key: $session_data->user_input, array: $user_data['linked_wallets'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet_resource' => $user_data['linked_wallets'][$session_data->user_input]['wallet_resource']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet_number' => $user_data['linked_wallets'][$session_data->user_input]['wallet']]);

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'LinkedWalletState', session_data: $session_data);

            // Execute the SusuAccountState
            return LinkedWalletMenu::mainMenu(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['Linked_wallets_state' => true]);

        // Execute the LinkedWalletsAction
        return LinkedWalletsAction::execute(session: $session, session_data: $session_data);
    }
}
