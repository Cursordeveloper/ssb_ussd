<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountPaymentMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Define frequencies array
        $frequencies = ['daily' => 'day(s)', 'weekly' => 'week(s)', 'monthly' => 'month(s)'];

        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Paying for how many '.$frequencies[data_get(target: $user_inputs, key: 'susu_account.frequency')].'?',
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
            message: 'Total frequency: '.$user_inputs['total_payment'].' '.$frequencies[data_get(target: $user_inputs, key: 'susu_account.frequency')].'. Total payment: GHS'.(int) $user_inputs['total_payment'] * data_get(target: $user_inputs, key: 'susu_account.susu_amount').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
