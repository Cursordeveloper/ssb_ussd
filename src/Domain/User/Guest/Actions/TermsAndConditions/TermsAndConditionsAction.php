<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\TermsAndConditions;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\TermsAndConditions\TermsAndConditionsMenu;
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
            ! array_key_exists(key: 'tcs_one', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'tcs_one', menu: TermsAndConditionsMenu::mainMenu(session: $session)),
            ! array_key_exists(key: 'tcs_two', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'tcs_two', menu: TermsAndConditionsMenu::tcsOne(session: $session)),
            ! array_key_exists(key: 'tcs_three', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'tcs_three', menu: TermsAndConditionsMenu::tcsTwo(session: $session)),
            ! array_key_exists(key: 'tcs_four', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'tcs_four', menu: TermsAndConditionsMenu::tcsThree(session: $session)),
            ! array_key_exists(key: 'end', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'end', menu: TermsAndConditionsMenu::lastTcs(session: $session)),

            default => TermsAndConditionsMenu::mainMenu(session: $session),
        };
    }
}
