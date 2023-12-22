<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your goal?',
            session_id: $session->session_id,
        );
    }

    public static function targetAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'What is your target amount?',
            session_id: $session->session_id,
        );
    }

    public static function durationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose duration\n1. One month\n2. Three months\n3. Six months\n4. Nine months\n5. One year",
            session_id: $session->session_id,
        );
    }

    public static function invalidDurationMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid duration\n1. One month\n2. Three months\n3. Six months\n4. Nine months\n5. One year",
            session_id: $session->session_id,
        );
    }

    public static function frequencyMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose debit frequency\n1. Daily\n2. Weekly\n3. Monthly",
            session_id: $session->session_id,
        );
    }

    public static function invalidFrequencyMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid frequency\n1. Daily\n2. Weekly\n3. Monthly",
            session_id: $session->session_id,
        );
    }

    public static function linkedWalletMenu($session, $wallets): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose wallet\n".Helpers::formatLinkedWallets(data_get(target: $wallets, key: 'data')),
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        // Get the user input data
        $data = json_decode($session->user_inputs, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'You are creating a ('.$data['goal'].') Goal Getter. GHS'.number_format((float) $data['amount']).' targeted for '.strtolower($data['duration']).'. GH24.00 will be debited weekly from '.$data['wallet'].' wallet. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
