<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuCollections\SusuCollectionsMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuFeesCharges\SusuFeesChargesMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuSchemes\SusuSchemesMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuWithdrawals\SusuWithdrawalsMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuCollections\AboutSusuCollectionsState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuFeesCharges\AboutSusuFeesChargesState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuSchemes\AboutSusuSchemesState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuWithdrawals\AboutSusuWithdrawalsState;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new AboutSusuSchemesState, 'menu' => new SusuSchemesMenu],
            '2' => ['class' => new AboutSusuCollectionsState, 'menu' => new SusuCollectionsMenu],
            '3' => ['class' => new AboutSusuWithdrawalsState, 'menu' => new SusuWithdrawalsMenu],
            '4' => ['class' => new AboutSusuFeesChargesState, 'menu' => new SusuFeesChargesMenu],
            '0' => ['class' => new SusuState, 'menu' => new SusuMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutSusuMenu::mainMenu(session: $session);
    }
}
