<?php

declare(strict_types=1);

namespace Domain\Susu\Data;

final class PersonalSusuData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'PersonalSusu',

                // Resource exposed attributes
                'attributes' => [
                    'account_name' => $user_inputs['account_name'],
                    'amount' => $user_inputs['amount'],
                    'wallet_number' => $user_inputs['wallet'],
                    'network' => $user_inputs['network'],
                ],
            ],
        ];
    }
}
