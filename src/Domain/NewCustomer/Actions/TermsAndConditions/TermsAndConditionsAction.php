<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Actions\TermsAndConditions;

use App\Menus\NewCustomer\TermsAndConditions\TermsAndConditionsMenu;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsAction
{
    public static function execute(Session $session, $session_data, $user_inputs): JsonResponse
    {
        // Terminate the session if user_inputs array has (end) and user_input is (#)
        if (array_key_exists('end', $user_inputs) && $session_data->user_input === '#') {
            // Return the terminateResponseBuilder
            return GeneralMenu::terminateSession(session: $session);
        }

        // Validate inputs and update the session input
        return match (true) {
            ! array_key_exists('tcs_one', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'tcs_one', TermsAndConditionsMenu::mainMenu(session: $session)),
            ! array_key_exists('tcs_two', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'tcs_two', TermsAndConditionsMenu::tcsOne(session: $session)),
            ! array_key_exists('tcs_three', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'tcs_three', TermsAndConditionsMenu::tcsTwo(session: $session)),
            ! array_key_exists('tcs_four', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'tcs_four', TermsAndConditionsMenu::tcsThree(session: $session)),
            ! array_key_exists('end', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'end', TermsAndConditionsMenu::lastTcs(session: $session)),
            default => TermsAndConditionsMenu::mainMenu(session: $session),
        };
    }
}
