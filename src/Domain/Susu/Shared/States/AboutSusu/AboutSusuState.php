<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\AboutSusu;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\AboutSusu\AboutSusuMenu;
use Domain\Susu\Shared\Menus\AboutSusu\SusuCollections\AboutSusuCollectionsMenu;
use Domain\Susu\Shared\Menus\AboutSusu\SusuFeesCharges\AboutSusuFeesChargesMenu;
use Domain\Susu\Shared\Menus\AboutSusu\SusuSchemes\AboutSusuSchemesMenu;
use Domain\Susu\Shared\Menus\AboutSusu\SusuWithdrawals\AboutSusuWithdrawalsMenu;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\States\AboutSusu\SusuCollections\AboutSusuCollectionsState;
use Domain\Susu\Shared\States\AboutSusu\SusuFeesCharges\AboutSusuFeesChargesState;
use Domain\Susu\Shared\States\AboutSusu\SusuSchemes\AboutSusuSchemesState;
use Domain\Susu\Shared\States\AboutSusu\SusuWithdrawals\AboutSusuWithdrawalsState;
use Domain\Susu\Shared\States\Susu\SusuState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutSusuSchemesState, 'menu' => new AboutSusuSchemesMenu],
            '2' => ['class' => new AboutSusuCollectionsState, 'menu' => new AboutSusuCollectionsMenu],
            '3' => ['class' => new AboutSusuWithdrawalsState, 'menu' => new AboutSusuWithdrawalsMenu],
            '4' => ['class' => new AboutSusuFeesChargesState, 'menu' => new AboutSusuFeesChargesMenu],
            '0' => ['class' => new SusuState, 'menu' => new SusuMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $service_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutSusuMenu::mainMenu(session: $session);
    }
}
