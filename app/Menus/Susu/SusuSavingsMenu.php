<?php

declare(strict_types=1);

namespace App\Menus\Susu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuSavingsMenu
{
    public static function chooseSusuSchemesMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Schemes\n1. Personal Susu Account\n2. Biz Susu Account\n3. Goal Getter Account",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function enterAccountNameMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter the account name',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function enterSusuAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter the susu amount',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function chooseLinkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose linked wallet\n1. 0244294960\n2. 0244637602\n3. 0244294960",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function confirmTermsConditionsMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Accept terms\n1. Yes\n2. No\n3. Terms & Conditions",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function pinConfirmationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter your susubox pin',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid input\n\n1. Personal Susu Account\n2. Biz Susu Account 2\n3. Goal Getter Account",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
