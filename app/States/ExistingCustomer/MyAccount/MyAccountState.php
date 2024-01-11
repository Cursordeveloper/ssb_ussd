<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\MyAccount;

use App\Menus\ExistingCustomer\MyAccount\MyAccountMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new LinkedWalletsState,
            '2' => new LinkNewWalletState,
            '3' => new ChangePinState,
            '0' => new ExistingCustomerState,
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute(session: $session, session_data: $session_data);
        }

        // Return the MyAccountMenu(invalidMainMenu)
        return MyAccountMenu::invalidMainMenu(session: $session);
    }
}
