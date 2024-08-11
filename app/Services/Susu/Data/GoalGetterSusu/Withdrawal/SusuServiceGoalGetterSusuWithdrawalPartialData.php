<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu\Withdrawal;

final class SusuServiceGoalGetterSusuWithdrawalPartialData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Withdrawal',

                // Resource exposed attributes
                'attributes' => [
                    'amount' => $user_inputs['withdrawal_amount'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
