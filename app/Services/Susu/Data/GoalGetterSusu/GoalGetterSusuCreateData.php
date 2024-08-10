<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu;

final class GoalGetterSusuCreateData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'GoalGetterSusu',

                // Resource exposed attributes
                'attributes' => [
                    'account_name' => $user_inputs['account_name'],
                    'target_amount' => $user_inputs['target_amount'],

                    'start_date' => $user_inputs['start_date'],
                    'duration' => $user_inputs['duration'],
                    'frequency' => $user_inputs['frequency'],

                    'accepted_terms' => true,
                ],

                // Resource related resources
                'relationships' => [
                    'linked_account' => [
                        'type' => 'LinkedAccount',
                        'attributes' => [
                            'resource_id' => $user_inputs['linked_wallet'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
