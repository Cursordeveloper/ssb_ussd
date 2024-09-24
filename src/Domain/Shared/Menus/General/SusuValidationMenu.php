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
            message: 'The account name must not exceed 20 characters. Please shorten it and try again.',
            session_id: $session->session_id,
        );
    }

    public static function susuAmountValidMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The minimum contribution must be GHS5.00 or more. Please adjust your amount and try again.',
            session_id: $session->session_id,
        );
    }

    public static function targetAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The target amount must be GHS500.00 or higher. Please adjust your input and try again.',
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

    public static function initialDepositAmountMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The initial deposit must be GHS5.00 and above. Try again.',
            session_id: $session->session_id,
        );
    }
}
