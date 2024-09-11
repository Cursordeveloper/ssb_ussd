<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Create;

final class PersonalSusuCreateData
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
                    'susu_amount' => $user_inputs['susu_amount'],
                    'initial_deposit' => $user_inputs['initial_deposit'],

                    'rollover_debit' => $user_inputs['rollover'],
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
