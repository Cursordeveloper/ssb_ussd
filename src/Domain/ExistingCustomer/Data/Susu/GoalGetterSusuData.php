<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Data\Susu;

final class GoalGetterSusuData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'GoalGetterSusu',

                // Resource exposed attributes
                'attributes' => [
                    'account_name' => $user_inputs['goal'],
                    'target_amount' => $user_inputs['amount'],
                    'duration' => $user_inputs['duration'],
                    'start_date' => $user_inputs['start_date'],
                    'frequency' => $user_inputs['frequency'],
                    'wallet_number' => $user_inputs['wallet'],
                    'network' => $user_inputs['network'],
                ],
            ],
        ];
    }
}
