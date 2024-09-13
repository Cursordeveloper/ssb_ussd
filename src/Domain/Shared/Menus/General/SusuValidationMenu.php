<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuValidationMenu
{
    public static function accountNameLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Account name\nThe account name cannot be more than 20 characters. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function susuAmountValidMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu amount\nThe minimum contribution is GHS5.00 and above. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function targetAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Target amount\nThe target amount should be GHS500.00 and above. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function isNumericMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\nThe value must be a valid number. Please correct your input and try again\n",
            session_id: $session->session_id,
        );
    }

    public static function initialDepositAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Initial deposit\nThe initial deposit must be GHS5.00 and above. Try again\n",
            session_id: $session->session_id,
        );
    }
}
