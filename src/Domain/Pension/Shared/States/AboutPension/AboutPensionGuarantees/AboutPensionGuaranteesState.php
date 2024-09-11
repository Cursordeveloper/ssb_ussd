<?php

declare(strict_types=1);

namespace Domain\Pension\Shared\States\AboutPension\AboutPensionGuarantees;

use Domain\Pension\Shared\Actions\AboutPension\BackToAboutPensionAction;
use Domain\Pension\Shared\Menus\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutPensionGuaranteesState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the AboutSusuState if user input is (0)
        if ($session_data->user_input === '0') {
            return BackToAboutPensionAction::execute(session: $session, session_data: $session_data);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the next content if user input is (#)
        if ($session_data->user_input === '#') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => (int) $user_inputs['content'] + 1]);

            // Return the next nextContentMenu
            return AboutPensionGuaranteesMenu::nextContentMenu(session: $session);
        }

        // Return the invalidChoiceMenu
        return AboutPensionGuaranteesMenu::invalidChoiceMenu(session: $session);
    }
}
