<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\General;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateSusuValidationMenu
{
    public static function accountNameLengthMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "The account name cannot be more than 20 characters. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function susuAmountValidMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "The minimum contribution is GHS5.00 and above. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function initialDepositAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "The initial deposit must be GHS5.00 and above. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function isNumericMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "The value must be a number. Try again\n",
            session_id: $session->session_id,
        );
    }

    public static function startWithTotalMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "The start with value cannot be more than 10 frequencies. Try again\n",
            session_id: $session->session_id,
        );
    }
}
