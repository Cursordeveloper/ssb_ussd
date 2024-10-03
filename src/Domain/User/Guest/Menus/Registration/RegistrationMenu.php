<?php

declare(strict_types=1);

namespace Domain\User\Guest\Menus\Registration;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter first name',
            session_id: $session->session_id,
        );
    }

    public static function lastNameMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter last name',
            session_id: $session->session_id,
        );
    }

    public static function choosePin(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Choose 4 digit SusuBox PIN code.',
            session_id: $session->session_id,
        );
    }

    public static function successResponse(Session $session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Registration in progress. You will receive notification to confirm status.',
            session_id: $session->session_id,
        );
    }
}
