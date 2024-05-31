<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu;

final class BizSusuCreateData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'BizSusu',

                // Resource exposed attributes
                'attributes' => [
                    'account_name' => $user_inputs['business_name'],
                    'susu_amount' => $user_inputs['susu_amount'],
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
