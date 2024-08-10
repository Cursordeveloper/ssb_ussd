<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu\Payment;

final class SusuServiceGoalGetterSusuPaymentAmountData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuPayment',

                // Resource exposed attributes
                'attributes' => [
                    'amount' => $user_inputs['amount'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
