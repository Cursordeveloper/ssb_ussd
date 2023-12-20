<?php

declare(strict_types=1);

namespace App\Menus\NewCustomer\AboutSusubox;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AboutSusuboxMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://susubox.app/about-susubox\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuboxOne($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuboxTwo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "2. When an unknown printer took a galley of type and scrambled it to make a type specimen book.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuboxThree($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "3. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.\n#. Next or 0. Main menu",
            session_id: $session->session_id,
        );
    }

    public static function aboutSusuboxLast($session, $session_data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "4. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece.\n#. Cancel or 0. Main menu",
            session_id: $session->session_id,
        );
    }
}
