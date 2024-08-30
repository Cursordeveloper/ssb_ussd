<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\AboutSusu\SusuFeesCharges;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Susu\AboutSusu\BackToAboutSusuAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\AboutSusu\SusuFeesCharges\AboutSusuFeesChargesMenu;
use Domain\Susu\Shared\Menus\AboutSusu\SusuSchemes\AboutSusuSchemesMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuFeesChargesState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the AboutSusuState if user input is (0)
        if ($session_data->user_input === '0') {
            return BackToAboutSusuAction::execute(session: $session, session_data: $session_data);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the next content if user input is (#)
        if ($session_data->user_input === '#') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => (int) $user_inputs['content'] + 1]);

            // Return the next nextContentMenu
            return AboutSusuFeesChargesMenu::nextContentMenu(session: $session);
        }

        // Execute MySusuAccountsAction action
        return AboutSusuSchemesMenu::invalidChoiceMenu(session: $session);
    }
}
