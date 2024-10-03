<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\SusuTerms;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuTermsMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['content' => 0]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/policies/terms-and-conditions\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function invalidChoiceMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input, try again.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function nextContentMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }
}
