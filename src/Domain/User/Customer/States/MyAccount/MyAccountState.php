<?php

declare(strict_types=1);

namespace Domain\User\Customer\States\MyAccount;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyAccount\ChangePin\ChangePinMenu;
use Domain\User\Customer\Menus\MyAccount\LinkedWallet\LinkedWalletsMenu;
use Domain\User\Customer\Menus\MyAccount\LinkedWallet\LinkNewWalletMenu;
use Domain\User\Customer\Menus\MyAccount\LinkGhanaCard\LinkGhCardMenu;
use Domain\User\Customer\Menus\MyAccount\MyAccountMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MyAccount\ChangePin\ChangePinState;
use Domain\User\Customer\States\MyAccount\LinkedWallet\LinkedWalletsState;
use Domain\User\Customer\States\MyAccount\LinkedWallet\LinkNewWalletState;
use Domain\User\Customer\States\MyAccount\LinkGhanaCard\LinkGhanaCardState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MyAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new LinkedWalletsState, 'menu' => new LinkedWalletsMenu],
            '2' => ['class' => new LinkNewWalletState, 'menu' => new LinkNewWalletMenu],
            '3' => ['class' => new LinkGhanaCardState, 'menu' => new LinkGhCardMenu],
            '4' => ['class' => new ChangePinState, 'menu' => new ChangePinMenu],
            '0' => ['class' => new CustomerWelcomeState, 'menu' => new CustomerWelcomeMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the MyAccountMenu(invalidMainMenu)
        return MyAccountMenu::invalidMainMenu(session: $session);
    }
}
