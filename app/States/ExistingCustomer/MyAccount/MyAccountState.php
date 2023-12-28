<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount;

use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Create the expected input arrays
        $options = ['1', '2', '3'];

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new LinkedWalletsState,
            '2' => new LinkNewWalletState,
            '3' => new ChangePinState,
        ];

        // Check if the customer input is a valid option
        if (in_array($session_data->user_input, $options) && array_key_exists($session_data->user_input, $stateMappings)) {
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute(session: $session, session_data: $session_data);
        }

        // Return the MyAccountMenu
        return MyAccountMenu::invalidMainMenu(session: $session);
    }
}
