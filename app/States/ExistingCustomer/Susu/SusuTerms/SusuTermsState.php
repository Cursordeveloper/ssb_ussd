<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\SusuTerms;

use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\Menus\ExistingCustomer\Susu\SusuTerms\SusuTermsMenu;
use App\States\ExistingCustomer\Susu\SusuState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTermsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the AboutSusuState if user input is (0)
        if ($session_data->user_input === '0') {
            // Define the return state and menu
            $susu_state = ['class' => new SusuState, 'menu' => new SusuMenu];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Return to the SusuState
            return $susu_state['menu']::mainMenu(session: $session);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the next content if user input is (#)
        if ($session_data->user_input === '#') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => (int) $user_inputs['content'] + 1]);

            // Return the next nextContentMenu
            return SusuTermsMenu::nextContentMenu(session: $session);
        }

        // Execute MySusuAccountsAction action
        return SusuTermsMenu::invalidChoiceMenu(session: $session);
    }
}
