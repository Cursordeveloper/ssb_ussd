<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePersonalSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Personal Susu Savings\n\nEnter the account name",
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

    public static function linkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n1. 0244294960\n2. 0244637602\n3. 0244294960",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function accountSummaryMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "A new personal susu (Account Name) with savings amount of GHS10 to be debited daily from your 0244294960 mobile money wallet. \nEnter your susubox pin to confirm.",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
