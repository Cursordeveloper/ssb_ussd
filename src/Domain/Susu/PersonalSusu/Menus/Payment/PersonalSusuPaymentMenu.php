<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Payment;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'How many day(s)?',
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $payment_data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total frequencies: '.data_get(target: $payment_data, key: 'data.attributes.frequencies').'. Total payment: GHS'.data_get(target: $payment_data, key: 'data.attributes.payment_amount').'. Fee GHS:'.data_get(target: $payment_data, key: 'data.attributes.charges').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
