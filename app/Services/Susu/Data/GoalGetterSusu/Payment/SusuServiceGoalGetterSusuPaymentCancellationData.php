<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu\Payment;

final class SusuServiceGoalGetterSusuPaymentCancellationData
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
