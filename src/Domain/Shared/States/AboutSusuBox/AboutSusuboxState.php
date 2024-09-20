<?php

declare(strict_types=1);

namespace Domain\Shared\States\AboutSusuBox;

use Domain\Shared\Action\AboutSusuBox\AboutSusuboxAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\AboutSusuBox\AboutSusuboxMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Welcome\WelcomeState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuboxState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Expected user input array
        $options = ['#', '0'];

        // Validate the user input
        if (! empty($user_inputs) && ! in_array($service_data->user_input, $options)) {
            return AboutSusuboxMenu::invalidInputMenu($session);
        }

        // If the user_input is '0', return back to home menu
        if ($service_data->user_input === '0') {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Return the WelcomeState
            return WelcomeState::execute(session: $session);
        }

        // Execute the TermsAndConditionsAction
        return AboutSusuboxAction::execute(session: $session, service_data: $service_data, user_inputs: $user_inputs);
    }
}
