<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your goal?',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function targetAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your target amount?',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function targetDurationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n1. One month\n2. Three months\n3. Six months\n4. Nine months\n5. One year",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function debitFrequencyMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose debit frequency\n1. Daily\n2. Weekly\n3. Monthly",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function linkedWalletMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n1. 0244294960 - MTN\n2. 0244637602 - Vodafone\n3. 0244294960 - AirtelTigo",
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'You are creating a Goal Getter to (Purpose). GHS30,000 target by 17/12/24. GH24.00 will be debited weekly from 0244294960 wallet. Enter your susubox pin to confirm.',
            session_id: data_get(target: $session, key: 'session_id'),
        );
    }
}
