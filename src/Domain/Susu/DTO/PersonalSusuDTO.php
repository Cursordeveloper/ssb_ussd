<?php

declare(strict_types=1);

namespace Domain\Susu\DTO;

final class PersonalSusuDTO
{
    public static function toArray(array $user_inputs): array
    {
        return [
            // Resource type and id
            'type' => 'PersonalSusu',

            // Resource exposed attributes
            'attributes' => [
                'account_name' => $user_inputs['account_name'],
                'amount' => $user_inputs['amount'],

                'wallet_number' => $user_inputs['wallet'],
                'network' => $user_inputs['network'],
            ],

            // Included data per the request
            'included' => [
                'scheme' => [
                    'type' => 'Scheme',
                    'attributes' => [
                        'resource_id' => $user_inputs['scheme'],
                    ],
                ],
            ],
        ];
    }
}
