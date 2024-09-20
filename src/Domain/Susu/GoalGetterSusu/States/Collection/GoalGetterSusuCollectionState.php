<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Collection;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Account\GoalGetterSusuAccountMenu;
use Domain\Susu\GoalGetterSusu\Menus\Collection\Goal\GoalGetterSusuGoalSummaryMenu;
use Domain\Susu\GoalGetterSusu\Menus\Collection\GoalGetterSusuCollectionMenu;
use Domain\Susu\GoalGetterSusu\Menus\Collection\Summary\GoalGetterSusuCollectionSummaryMenu;
use Domain\Susu\GoalGetterSusu\States\Account\GoalGetterSusuAccountState;
use Domain\Susu\GoalGetterSusu\States\Collection\Goal\GoalGetterSusuGoalSummaryState;
use Domain\Susu\GoalGetterSusu\States\Collection\Summary\GoalGetterSusuCollectionSummaryState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCollectionState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new GoalGetterSusuCollectionSummaryState, 'menu' => new GoalGetterSusuCollectionSummaryMenu],
            '2' => ['state' => new GoalGetterSusuGoalSummaryState, 'menu' => new GoalGetterSusuGoalSummaryMenu],
            '0' => ['state' => new GoalGetterSusuAccountState, 'menu' => new GoalGetterSusuAccountMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($service_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['state']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return GoalGetterSusuCollectionMenu::invalidMainMenu(session: $session);
    }
}
