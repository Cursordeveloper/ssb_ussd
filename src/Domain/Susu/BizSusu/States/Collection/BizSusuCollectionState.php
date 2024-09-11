<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Collection;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Account\BizSusuAccountMenu;
use Domain\Susu\BizSusu\Menus\Collection\BizSusuCollectionMenu;
use Domain\Susu\BizSusu\Menus\Collection\Pause\BizSusuCollectionPauseMenu;
use Domain\Susu\BizSusu\Menus\Collection\Summary\BizSusuCollectionSummaryMenu;
use Domain\Susu\BizSusu\States\Account\BizSusuAccountState;
use Domain\Susu\BizSusu\States\Collection\Pause\BizSusuCollectionPauseState;
use Domain\Susu\BizSusu\States\Collection\Summary\BizSusuCollectionSummaryState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCollectionState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new BizSusuCollectionSummaryState, 'menu' => new BizSusuCollectionSummaryMenu],
            '2' => ['state' => new BizSusuCollectionPauseState, 'menu' => new BizSusuCollectionPauseMenu],
            '0' => ['state' => new BizSusuAccountState, 'menu' => new BizSusuAccountMenu],
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
        return BizSusuCollectionMenu::invalidMainMenu(session: $session);
    }
}
