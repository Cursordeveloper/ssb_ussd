<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\AboutSusuBox;

use App\Common\PolicyText;
use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuboxMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => 0]);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: PolicyText::getPolicyUrl(policy: 'about-susubox')."\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function invalidInputMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function nextTextMenu(Session $session, string $content): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: $content."\n#. Next or 0 Back",
            session_id: $session->session_id,
        );
    }
}
