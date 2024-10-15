<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\AboutSusu\SusuSchemes;

use App\Common\PolicyText;
use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuSchemesMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => 0]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: PolicyText::getPolicyUrl(policy: 'about-susu')."\n#. Next or 0. Main menu",
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

    public static function invalidInputMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/susu/about\n#. Next or 0. Back",
            session_id: $session->session_id,
        );
    }
}
