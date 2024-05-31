<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountWithdrawalMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Get the susu_account data from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the menu for the susu_scheme
        if (data_get(target: $user_inputs, key: 'susu_scheme.code') === 'SSB-PSS001' || data_get(target: $user_inputs, key: 'susu_scheme.code') === 'SSB-BSS002') {
            return ResponseBuilder::ussdResourcesResponseBuilder(
                message: 'How many cycle(s)?:',
                session_id: $session->session_id,
            );
        }

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter amount:',
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Withdrawal Amount: GHS'.$user_inputs['withdrawal_amount'].'. Susubox Commission: GHS2.00. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
