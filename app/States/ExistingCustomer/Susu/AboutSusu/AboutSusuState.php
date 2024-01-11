<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use Domain\ExistingCustomer\Actions\Susu\AboutSusu\AboutSusuAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Validate the user input
        if (! empty($user_inputs) && $session_data->user_input !== '#') {
            return AboutSusuMenu::invalidInputMenu($session);
        }

        // Execute the AboutSusuAction
        return AboutSusuAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs);
    }
}
