<?php

declare(strict_types=1);

namespace App\Menus\Registration;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationMenu
{
    public static function firstName($session): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter your first name.',
            session_id: $session,
        );
    }

    public static function lastName($session): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter your last name.',
            session_id: $session,
        );
    }

    public static function choosePin($session): JsonResponse {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Choose your 4 digit ssb pin.',
            session_id: $session,
        );
    }

    public static function invalidInput($session): JsonResponse {
        return ResponseBuilder::invalidResponseBuilder(
            message: 'There was a problem with your request. Try again later.',
            session_id: $session,
        );
    }

    public static function successResponse($session): JsonResponse {
        return ResponseBuilder::invalidResponseBuilder(
            message: 'Congratulations! Registration successful.',
            session_id: $session,
        );
    }
}
