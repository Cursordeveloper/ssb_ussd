<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Biz Susu Savings\nEnter the business name",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function susuAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter the susu amount',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function debitFrequencyMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose frequency\n1. Daily\n2. Weekly\n3. Monthly",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n1. 0244294960\n2. 0244637602\n3. 0244294960",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "A new business susu (Account Name) with savings amount of GHS10 to be debited weekly from your 0244294960 mobile money wallet. \nEnter your susubox pin to confirm.",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
