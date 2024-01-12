<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\ManualSusuPayment;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentMenu
{
    public static function frequencyMenu($session, string $frequency): JsonResponse
    {
        // Define frequencies array
        $frequencies = ['daily' => 'day(s)', 'weekly' => 'week(s)', 'monthly' => 'month(s)'];

        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: 'How many '.$frequencies[strtolower($frequency)].'?',
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Define frequencies array
        $frequencies = ['daily' => 'day(s)', 'weekly' => 'week(s)', 'monthly' => 'month(s)'];

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total frequency: '.$user_inputs['total_payments'].' '.$frequencies[strtolower($user_inputs['account_frequency'])].'. Total payment: GHS'.(int) $user_inputs['total_payments'] * 200 .'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }

    public static function confirmation($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter pin to confirm',
            session_id: $session->session_id,
        );
    }
}
