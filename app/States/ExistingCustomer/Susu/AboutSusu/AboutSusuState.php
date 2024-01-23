<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\FeesCharges\FeesChargesMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SettlementsWithdrawals\SettlementsWithdrawalsMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuCollections\SusuCollectionsMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\SusuSchemes\SusuSchemesMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\Susu\AboutSusu\FeesCharges\FeesChargesState;
use App\States\ExistingCustomer\Susu\AboutSusu\SettlementsWithdrawals\SettlementsWithdrawalsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuCollections\SusuCollectionsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuSchemes\SusuSchemesState;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuSchemesState, 'menu' => new SusuSchemesMenu],
            '2' => ['class' => new SusuCollectionsState, 'menu' => new SusuCollectionsMenu],
            '3' => ['class' => new SettlementsWithdrawalsState, 'menu' => new SettlementsWithdrawalsMenu],
            '4' => ['class' => new FeesChargesState, 'menu' => new FeesChargesMenu],
            '0' => ['class' => new SusuState, 'menu' => new SusuMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return AboutSusuMenu::mainMenu(session: $session);
    }
}
