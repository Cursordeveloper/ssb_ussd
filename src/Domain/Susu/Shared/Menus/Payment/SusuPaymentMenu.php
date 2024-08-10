<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\Payment;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuPaymentMenu
{
    public static function frequencyFrequencyMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Define frequencies array
        $frequencies = ['daily' => 'day(s)', 'weekly' => 'week(s)', 'monthly' => 'month(s)'];

        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter '.$frequencies[data_get(target: $user_inputs, key: 'susu_account.attributes.frequency')].' to pay',
            session_id: $session->session_id,
        );
    }

    public static function amountPaymentMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter amount to pay',
            session_id: $session->session_id,
        );
    }

    public static function paymentFrequencyNarrationMenu(Session $session, array $payment_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total frequencies: '.data_get(target: $payment_data, key: 'data.attributes.frequencies').'. Total payment: GHS'.data_get(target: $payment_data, key: 'data.attributes.payment_amount').'. Fee GHS'.data_get(target: $payment_data, key: 'data.attributes.charges').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }

    public static function paymentAmountNarrationMenu(Session $session, array $payment_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total payment: GHS'.data_get(target: $payment_data, key: 'data.attributes.payment_amount').'. Fee GHS'.data_get(target: $payment_data, key: 'data.attributes.charges').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
