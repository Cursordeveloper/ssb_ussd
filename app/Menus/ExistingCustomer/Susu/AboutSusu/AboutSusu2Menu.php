<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\AboutSusu;

use App\Common\ResponseBuilder;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusu2Menu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::resetUserInputs(session: $session);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://cursorinnovations.site/susubox/policies/terms-and-conditions\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function invalidInputMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuOne($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuTwo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "2. When an unknown printer took a galley of type and scrambled it to make a type specimen book.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuThree($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "3. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function lastAboutSusu($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: '4. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece.',
            session_id: $session->session_id,
        );
    }
}
