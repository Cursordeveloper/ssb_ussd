<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\StartSusu;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Create\BizSusuCreateMenu;
use Domain\Susu\BizSusu\States\Create\BizSusuCreateState;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Domain\Susu\FlexySusu\States\Create\FlexySusuCreateState;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Domain\Susu\GoalGetterSusu\States\Create\GoalGetterSusuCreateState;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Domain\Susu\PersonalSusu\States\Create\PersonalSusuCreateState;
use Domain\Susu\Shared\Actions\Common\GetSusuSchemesAction;
use Domain\Susu\Shared\Menus\StartSusu\StartSusuMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartSusuState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new PersonalSusuCreateState, 'menu' => new PersonalSusuCreateMenu],
            '2' => ['class' => new BizSusuCreateState, 'menu' => new BizSusuCreateMenu],
            '3' => ['class' => new GoalGetterSusuCreateState, 'menu' => new GoalGetterSusuCreateMenu],
            '4' => ['class' => new FlexySusuCreateState, 'menu' => new FlexySusuCreateMenu],
        ];

        // Evaluate the condition and execute the corresponding action
        return match (true) {
            array_key_exists(key: $service_data->user_input, array: $stateMappings) => self::stateExecution(session: $session, service_data: $service_data, stateMappings: $stateMappings),
            default => StartSusuMenu::invalidSusuSchemesMenu(session: $session),
        };
    }

    private static function stateExecution(Session $session, $service_data, $stateMappings): JsonResponse
    {
        // Get the customer option state
        $customer_state = $stateMappings[$service_data->user_input];

        // Update the customer session action
        SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

        // Execute the SessionInputUpdateAction
        GetSusuSchemesAction::execute(session: $session, service_data: $service_data);

        // Execute the state
        return $customer_state['menu']::mainMenu(session: $session);
    }
}
