<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePersonalSusuMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter account name',
            session_id: $session->session_id,
        );
    }

    public static function susuAmountMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter susu amount',
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

        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'You are creating a ('.$data['account_name'].') personal susu. GHS'.$data['amount'].' will be debited daily from your '.$data['wallet'].' wallet. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
