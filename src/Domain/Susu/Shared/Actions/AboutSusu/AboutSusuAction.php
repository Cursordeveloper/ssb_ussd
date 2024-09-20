<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\AboutSusu;

use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\AboutSusu\AboutSusuMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuAction
{
    public static function execute(Session $session, $service_data, $user_inputs): JsonResponse
    {
        // Validate inputs and update the session input
        return match (true) {
            ! array_key_exists(key: 'about_susu_one', array: $user_inputs) => UpdateAndReturnMenuAction::execute($session, key: 'about_susu_one', menu: AboutSusuMenu::mainMenu(session: $session)),

            default => AboutSusuMenu::mainMenu(session: $session),
        };
    }
}
