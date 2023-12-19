<?php

declare(strict_types=1);

namespace App\Menus\NewCustomer\TermsAndConditionsMenu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://cursorinnovations.site/susubox/policies/terms-and-conditions\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function tcsOne($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function tcsTwo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "2. When an unknown printer took a galley of type and scrambled it to make a type specimen book.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function tcsThree($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "3. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.\n#. Next",
            session_id: $session->session_id,
        );
    }

    public static function lastTcs($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: "4. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece.\n",
            session_id: $session->session_id,
        );
    }
}
