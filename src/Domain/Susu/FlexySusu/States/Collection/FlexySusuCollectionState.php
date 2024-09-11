<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Collection;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Account\FlexySusuAccountMenu;
use Domain\Susu\FlexySusu\Menus\Collection\FlexySusuCollectionMenu;
use Domain\Susu\FlexySusu\Menus\Collection\Pause\FlexySusuCollectionPauseMenu;
use Domain\Susu\FlexySusu\Menus\Collection\Summary\FlexySusuCollectionSummaryMenu;
use Domain\Susu\FlexySusu\States\Account\FlexySusuAccountState;
use Domain\Susu\FlexySusu\States\Collection\Pause\FlexySusuCollectionPauseState;
use Domain\Susu\FlexySusu\States\Collection\Summary\FlexySusuCollectionSummaryState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCollectionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new FlexySusuCollectionSummaryState, 'menu' => new FlexySusuCollectionSummaryMenu],
            '2' => ['state' => new FlexySusuCollectionPauseState, 'menu' => new FlexySusuCollectionPauseMenu],
            '0' => ['state' => new FlexySusuAccountState, 'menu' => new FlexySusuAccountMenu],
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
        return FlexySusuCollectionMenu::invalidMainMenu(session: $session);
    }
}
