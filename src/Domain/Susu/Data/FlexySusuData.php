<?php

declare(strict_types=1);

namespace Domain\Susu\Data;

final class FlexySusuData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'FlexySusu',

                // Resource exposed attributes
                'attributes' => [
                    'account_name' => $user_inputs['account_name'],
                    'min_range' => $user_inputs['min_range'],
                    'max_range' => $user_inputs['max_range'],
                    'frequency' => $user_inputs['frequency'],
                    'recurring_debit' => $user_inputs['recurring_debit'],
                    'wallet_number' => $user_inputs['wallet'],
                    'network' => $user_inputs['network'],
                ],
            ],
        ];
    }
}
