<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Settlement;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementAllPendingMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementPendingMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementZeroOutMenu;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new PersonalSusuSettlementPendingState, 'menu' => new PersonalSusuSettlementPendingMenu],
            '2' => ['state' => new PersonalSusuSettlementAllPendingState, 'menu' => new PersonalSusuSettlementAllPendingMenu],
            '3' => ['state' => new PersonalSusuSettlementZeroOutState, 'menu' => new PersonalSusuSettlementZeroOutMenu],

            '0' => ['state' => new PersonalSusuAccountState, 'menu' => new PersonalSusuAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['state']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return PersonalSusuSettlementMenu::invalidMainMenu(session: $session);
    }
}
