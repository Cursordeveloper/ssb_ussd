<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\AboutSusu\SusuSchemes;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuSchemesMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => 1]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/susu/susu-schemes\n#. Next or 0. Back",
            session_id: $session->session_id,
        );
    }

    public static function nextContentMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next or 0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidChoiceMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/susu/about\n#. Next or 0. Back",
            session_id: $session->session_id,
        );
    }
}
