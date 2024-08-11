<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Collection;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\Menus\Collection\Pause\PersonalSusuCollectionPauseMenu;
use Domain\Susu\PersonalSusu\Menus\Collection\PersonalSusuCollectionMenu;
use Domain\Susu\PersonalSusu\Menus\Collection\Summary\PersonalSusuCollectionSummaryMenu;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Domain\Susu\PersonalSusu\States\Collection\Pause\PersonalSusuCollectionPauseState;
use Domain\Susu\PersonalSusu\States\Collection\Summary\PersonalSusuCollectionSummaryState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new PersonalSusuCollectionSummaryState, 'menu' => new PersonalSusuCollectionSummaryMenu],
            '2' => ['state' => new PersonalSusuCollectionPauseState, 'menu' => new PersonalSusuCollectionPauseMenu],
            '0' => ['state' => new PersonalSusuAccountState, 'menu' => new PersonalSusuAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['state']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return PersonalSusuCollectionMenu::invalidMainMenu(session: $session);
    }
}
