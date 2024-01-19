<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Define frequencies array
        $frequencies = ['daily' => 'day(s)', 'weekly' => 'week(s)', 'monthly' => 'month(s)'];

        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'How many '.$frequencies[strtolower(data_get(target: $user_inputs, key: 'account_frequency'))].'?',
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
            message: 'Total frequency: '.$user_inputs['total_payment'].' '.$frequencies[strtolower($user_inputs['account_frequency'])].'. Total payment: GHS'.(int) $user_inputs['total_payment'] * 200 .'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
