<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationValidationMenu
{
    public static function isNameLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The first name must not exceed 25 characters. Please shorten it and try again.',
            session_id: $session->session_id,
        );
    }

    public static function isNameStringMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The input you provided is invalid. Please check it and try again.',
            session_id: $session->session_id,
        );
    }

    public static function isNumericMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The value must be a valid number. Please correct your input and try again.',
            session_id: $session->session_id,
        );
    }

    public static function isPinLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The PIN length is invalid. Please correct your input and try again.',
            session_id: $session->session_id,
        );
    }
}
