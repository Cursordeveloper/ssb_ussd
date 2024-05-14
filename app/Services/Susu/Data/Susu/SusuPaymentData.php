<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\Susu;

final class SusuPaymentData
{
    public static function toArray(array $payment_data): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Payment',

                // Resource exposed attributes
                'attributes' => [
                    'total_payment' => data_get(target: $payment_data, key: 'total_payment'),
                ],
            ],
        ];
    }
}
