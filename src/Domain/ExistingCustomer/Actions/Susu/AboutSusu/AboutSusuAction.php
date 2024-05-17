<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\AboutSusu;

use App\Menus\ExistingCustomer\Susu\AboutSusu\AboutSusuMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuAction
{
    public static function execute(Session $session, $session_data, $user_inputs): JsonResponse
    {
        // Validate inputs and update the session input
        return match (true) {
            ! array_key_exists('about_susu_one', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_susu_one', AboutSusuMenu::mainMenu(session: $session)),
            ! array_key_exists('about_susu_two', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_susu_two', AboutSusuMenu::aboutSusuOne(session: $session)),
            ! array_key_exists('about_susu_three', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_susu_three', AboutSusuMenu::aboutSusuTwo(session: $session)),
            ! array_key_exists('about_susu_four', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'about_susu_four', AboutSusuMenu::aboutSusuThree(session: $session)),
            ! array_key_exists('end', $user_inputs) => UpdateAndReturnMenuAction::execute($session, 'end', AboutSusuMenu::lastAboutSusu(session: $session)),
            default => AboutSusuMenu::mainMenu(session: $session),
        };
    }
}
