<?php

declare(strict_types=1);

namespace Domain\Investment\Shared\States\AboutInvestment\InvestmentSchemes;

use Domain\Investment\Shared\Menus\AboutInvestment\InvestmentSchemes\InvestmentSchemesMenu;
use Domain\Investment\Shared\States\AboutInvestment\BackToAboutInvestmentAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentSchemesState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the AboutSusuState if user input is (0)
        if ($session_data->user_input === '0') {
            return BackToAboutInvestmentAction::execute(session: $session, session_data: $session_data);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the next content if user input is (#)
        if ($session_data->user_input === '#') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => (int) $user_inputs['content'] + 1]);

            // Return the next nextContentMenu
            return InvestmentSchemesMenu::nextContentMenu(session: $session);
        }

        // Return the invalidChoiceMenu
        return InvestmentSchemesMenu::invalidChoiceMenu(session: $session);
    }
}
