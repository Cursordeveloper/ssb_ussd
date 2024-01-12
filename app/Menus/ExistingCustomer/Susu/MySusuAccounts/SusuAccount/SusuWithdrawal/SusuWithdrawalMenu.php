<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalMenu
{
    public static function withdrawalAmountMenu($session): JsonResponse
    {
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
