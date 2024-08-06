<?php

declare(strict_types=1);

namespace Domain\Shared\Action\AboutSusubox;

use App\Menus\Shared\AboutSusubox\AboutSusuboxMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuboxAction
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
            ! array_key_exists('about_one', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_one', AboutSusuboxMenu::mainMenu(session: $session)),
            ! array_key_exists('about_two', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_two', AboutSusuboxMenu::aboutOne(session: $session)),
            ! array_key_exists('about_three', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_three', AboutSusuboxMenu::aboutTwo(session: $session)),
            ! array_key_exists('about_four', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_four', AboutSusuboxMenu::aboutThree(session: $session)),
            ! array_key_exists('end', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'end', AboutSusuboxMenu::aboutLast(session: $session)),

            default => AboutSusuboxMenu::mainMenu(session: $session),
        };
    }
}
