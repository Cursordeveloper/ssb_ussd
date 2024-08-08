<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Payment;

final class SusuServiceBizSusuPaymentFrequencyData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuPayment',

                // Resource exposed attributes
                'attributes' => [
                    'frequencies' => (int) $user_inputs['frequency'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
