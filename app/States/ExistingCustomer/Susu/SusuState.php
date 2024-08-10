<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu;

use App\Menus\ExistingCustomer\ExistingCustomerMenu;
use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use App\Menus\ExistingCustomer\Susu\StartSusu\StartSusuMenu;
use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\Menus\ExistingCustomer\Susu\SusuTerms\SusuTermsMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\StartSusuState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\Susu\Shared\States\MySusuAccounts\MySusuAccountsState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
            '2' => ['class' => new StartSusuState, 'menu' => new StartSusuMenu],
            '3' => ['class' => new AboutSusuState, 'menu' => new AboutSusuMenu],
            '4' => ['class' => new SusuTermsState, 'menu' => new SusuTermsMenu],
            '0' => ['class' => new ExistingCustomerState, 'menu' => new ExistingCustomerMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the SusuMenu(invalidMainMenu)
        return SusuMenu::invalidMainMenu(session: $session);
    }
}
