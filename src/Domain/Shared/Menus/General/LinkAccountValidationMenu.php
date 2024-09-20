<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkAccountValidationMenu
{
    public static function isPhoneNumberLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The phone number must be upto 10 characters. Please correct your input and try again.',
            session_id: $session->session_id,
        );
    }

    public static function isPhoneNumberMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The phone number you entered is invalid. Please correct it and try again.',
            session_id: $session->session_id,
        );
    }
}
