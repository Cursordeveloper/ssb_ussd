<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Payment;

final class SusuServiceFlexySusuPaymentCancellationData
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
