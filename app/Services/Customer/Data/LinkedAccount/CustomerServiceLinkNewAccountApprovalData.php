<?php

declare(strict_types=1);

namespace App\Services\Customer\Data\LinkedAccount;

final class CustomerServiceLinkNewAccountApprovalData
{
    public static function toArray(string $phone_number, string $resource_id): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'LinkedAccount',

                // Resource exposed attributes
                'attributes' => [
                    'account_number' => $phone_number,
                ],

                // Included resources
                'relationships' => [
                    'scheme' => [
                        'type' => 'Scheme',
                        'attributes' => [
                            'resource_id' => $resource_id,
                        ],
                    ],
                ],
            ],
        ];
    }
}
