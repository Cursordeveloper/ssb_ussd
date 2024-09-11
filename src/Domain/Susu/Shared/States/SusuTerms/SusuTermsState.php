<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\SusuTerms;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Susu\SusuMenu;
use Domain\Susu\Shared\Menus\SusuTerms\SusuTermsMenu;
use Domain\Susu\Shared\States\Susu\SusuState;
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
            SessionStateUpdateAction::execute(session: $session, state: class_basename($susu_state['class']), session_data: $session_data);

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
