<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Withdrawal;

final class SusuServiceFlexySusuWithdrawalFullData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuWithdrawal',

                // Resource exposed attributes
                'attributes' => [
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
