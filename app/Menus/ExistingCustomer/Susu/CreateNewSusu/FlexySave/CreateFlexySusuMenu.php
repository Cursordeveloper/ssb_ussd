<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
            session_id: $session->session_id,
        );
    }

    public static function debitFrom($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter starting amount range',
            session_id: $session->session_id,
        );
    }

    public static function debitTo($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter ending amount range',
            session_id: $session->session_id,
        );
    }

    public static function debitFrequencyMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose frequency\n1. Daily\n2. Weekly\n3. Monthly",
            session_id: $session->session_id,
        );
    }

    public static function enforceStrictDebitMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Enforce strict debit?\n1. Yes\n2. No",
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
            message: 'You are creating Flexy savings. Between GHS10 and GHS40 will randomly be debited weekly from your '.$data['wallet'].' mobile money wallet. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
