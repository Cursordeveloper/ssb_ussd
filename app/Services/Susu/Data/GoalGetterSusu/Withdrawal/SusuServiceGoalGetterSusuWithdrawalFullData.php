<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu\Withdrawal;

final class SusuServiceGoalGetterSusuWithdrawalFullData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Withdrawal',

                // Resource exposed attributes
                'attributes' => [
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
