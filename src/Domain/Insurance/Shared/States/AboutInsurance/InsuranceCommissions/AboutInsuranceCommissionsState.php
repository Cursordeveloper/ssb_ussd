<?php

declare(strict_types=1);

namespace Domain\Insurance\Shared\States\AboutInsurance\InsuranceCommissions;

use Domain\Insurance\Shared\Menus\AboutInsurance\InsuranceCommissions\InsuranceCommissionsMenu;
use Domain\Insurance\Shared\States\AboutInsurance\BackToAboutInsuranceAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutInsuranceCommissionsState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Return to the AboutSusuState if user input is (0)
        if ($service_data->user_input === '0') {
            return BackToAboutInsuranceAction::execute(session: $session, service_data: $service_data);
        }

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the next content if user input is (#)
        if ($service_data->user_input === '#') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => (int) $user_inputs['content'] + 1]);

            // Return the next nextContentMenu
            return InsuranceCommissionsMenu::nextContentMenu(session: $session);
        }

        // Return the invalidChoiceMenu
        return InsuranceCommissionsMenu::invalidChoiceMenu(session: $session);
    }
}
