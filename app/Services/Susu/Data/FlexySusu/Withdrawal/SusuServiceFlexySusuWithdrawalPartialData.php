<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Withdrawal;

final class SusuServiceFlexySusuWithdrawalPartialData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuWithdrawal',

                // Resource exposed attributes
                'attributes' => [
                    'amount' => $user_inputs['withdrawal_amount'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
