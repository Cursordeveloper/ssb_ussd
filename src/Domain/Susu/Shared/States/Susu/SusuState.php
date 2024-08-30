<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\Susu;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\AboutSusu\AboutSusuMenu;
use Domain\Susu\Shared\Menus\StartSusu\StartSusuMenu;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\Menus\SusuTerms\SusuTermsMenu;
use Domain\Susu\Shared\States\AboutSusu\AboutSusuState;
use Domain\Susu\Shared\States\StartSusu\StartSusuState;
use Domain\Susu\Shared\States\SusuTerms\SusuTermsState;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\User\Customer\Menus\Welcome\CustomerWelcomeMenu;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
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
            '0' => ['class' => new CustomerWelcomeState, 'menu' => new CustomerWelcomeMenu],
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
