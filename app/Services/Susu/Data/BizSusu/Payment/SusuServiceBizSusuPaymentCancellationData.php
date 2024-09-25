<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Payment;

final class SusuServiceBizSusuPaymentCancellationData
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
