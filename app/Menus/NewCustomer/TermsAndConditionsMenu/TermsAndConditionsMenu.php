<?php

declare(strict_types=1);

namespace App\Menus\NewCustomer\TermsAndConditionsMenu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsMenu
{
    public static function main($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "https://cursorinnovations.site/susubox/policies/terms-and-conditions\n#. Next",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function tcsOne($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.\n#. Next",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function tcsTwo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.\n#. Next",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function tcsThree($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop.\n#. Next",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function lastTcs($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
