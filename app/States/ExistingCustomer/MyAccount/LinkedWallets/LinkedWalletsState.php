<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount\LinkedWallets;

use App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet\LinkedWalletMenu;
use App\Menus\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsMenu;
use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
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
            $state = ['class' => new MyAccountState, 'menu' => new MyAccountMenu];

            // Execute the SessionInputUpdateAction(reset)
            SessionInputUpdateAction::resetUserInputs(session: $session);
            SessionInputUpdateAction::resetUserData(session: $session);

            // Execute the SessionInputUpdateAction(resetState)
            SessionInputUpdateAction::resetState(session: $session, state: class_basename($state['class']));

            // Return the WelcomeState
            return $state['menu']::mainMenu(session: $session);
        }

        // Get the session user_data
        $user_data = json_decode($session->user_data, associative: true);

        // Execute the LinkedWallet if user input is valid
        if (array_key_exists(key: $session_data->user_input, array: $user_data['linked_wallets'])) {
            // Reset user data and input
            SessionInputUpdateAction::resetUserData(session: $session);
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Update the SessionInputUpdateAction user_data field
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet_resource' => $user_data['linked_wallets'][$session_data->user_input]['wallet_resource']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet_number' => $user_data['linked_wallets'][$session_data->user_input]['wallet']]);
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['wallet_network' => $user_data['linked_wallets'][$session_data->user_input]['network']]);

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'LinkedWalletState', session_data: $session_data);

            // Execute the SusuAccountState
            return LinkedWalletMenu::mainMenu(session: $session);
        }

        // Execute the LinkedWalletsAction
        return LinkedWalletsMenu::invalidLinkedWalletCollectionMenu(session: $session, wallets: $user_data['linked_wallets']);
    }
}
