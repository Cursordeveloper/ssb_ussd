<?php

declare(strict_types=1);

namespace App\States\Account;

use App\Common\ResponseBuilder;
use App\Menus\Account\MyAccountMenu;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountState
{
    public static function execute(
        Session $session,
        $session_data,
    ): JsonResponse {
        // Pin validation

        // Create the expected input arrays
        $options = ['1', '2', '3', '0'];

        // Assign the customer input to a variable
        $customer_input = $session_data->input_user;

        // If the input is '0', terminate the session
        if ($customer_input === '0') {
            return ResponseBuilder::terminateResponseBuilder(session_id: data_get(target: $session, key: 'session_id'));
        }

        // Define a mapping between customer input and states
        $stateMappings = ['1' => new LinkedWalletsState(), '2' => new LinkNewWalletState(), '3' => new ChangePinState(), '0' => null];

        // Check if the customer input is a valid option
        if (in_array($customer_input, $options) && array_key_exists($customer_input, $stateMappings)) {
            $customer_state = $stateMappings[$customer_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state));

            // Execute the state
            return $customer_state::execute(session: $session, request: $session_data);
        }

        // Return the MyAccountMenu
        return MyAccountMenu::invalidMainMenu(session: $session);
    }
}
