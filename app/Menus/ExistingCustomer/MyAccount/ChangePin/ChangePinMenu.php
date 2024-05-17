<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\MyAccount\ChangePin;

use App\Common\ResponseBuilder;
use App\Menus\Shared\GeneralMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ChangePinMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter current pin.',
            session_id: $session->session_id,
        );
    }

    public static function invalidCurrentPin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid entry, try again\nEnter current pin.",
            session_id: $session->session_id,
        );
    }

    public static function enterNewPin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter new pin.',
            session_id: $session->session_id,
        );
    }

    public static function invalidNewPin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid entry, try again\nEnter new pin.",
            session_id: $session->session_id,
        );
    }

    public static function confirmNewPin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Confirm new pin.',
            session_id: $session->session_id,
        );
    }

    public static function invalidConfirmNewPin($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid entry, try again\nConfirm new pin.",
            session_id: $session->session_id,
        );
    }

    public static function successful($session): JsonResponse
    {
        return GeneralMenu::requestNotification($session);
    }
}
