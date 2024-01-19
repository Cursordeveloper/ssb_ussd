<?php

declare(strict_types=1);

namespace App\Menus\NewCustomer\Registration;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationMenu
{
    public static function firstName($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter first name.',
            session_id: $session->session_id,
        );
    }

    public static function lastName($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter last name.',
            session_id: $session->session_id,
        );
    }

    public static function choosePin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Choose 4 digit Susubox pin.',
            session_id: $session->session_id,
        );
    }

    public static function successResponse($session): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Registration in progress. You will receive notification to confirm status.',
            session_id: $session->session_id,
        );
    }
}
