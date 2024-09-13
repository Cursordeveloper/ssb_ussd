<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Payment;

final class SusuServicePersonalSusuPaymentCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuPayment',
            ],
        ];
    }
}
