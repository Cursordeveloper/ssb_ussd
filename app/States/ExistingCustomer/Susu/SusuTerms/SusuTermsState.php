<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\SusuTerms;

use App\Menus\ExistingCustomer\Susu\SusuTerms\SusuTermsMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\SusuTerms\SusuTermsAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTermsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Validate the user input
        if (! empty($user_inputs) && $session_data->user_input !== '#') {
            return SusuTermsMenu::invalidInputMenu($session);
        }

        // Execute the SusuTermsAction
        return SusuTermsAction::execute(session: $session, session_data: $session_data, user_inputs: $user_inputs);
    }
}
