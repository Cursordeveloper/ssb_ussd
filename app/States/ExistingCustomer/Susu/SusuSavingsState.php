<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu;

use App\Menus\ExistingCustomer\Susu\SusuSavingsMenu;
use App\States\ExistingCustomer\Susu\CreateNewSusu\CreateNewSusuState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSavingsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Pin validation

        // Create the expected input arrays
        $options = ['1', '2', '0'];

        // Define a mapping between customer input and states
        $stateMappings = ['1' => new MySusuAccountsState, '2' => new CreateNewSusuState, '0' => null];

        // Check if the customer input is a valid option
        if (in_array($session_data->user_input, $options) && array_key_exists($session_data->user_input, $stateMappings)) {
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute(session: $session, session_data: $session_data);
        }

        // Return the MyAccountMenu
        return SusuSavingsMenu::invalidMainMenu(session: $session);
    }
}
