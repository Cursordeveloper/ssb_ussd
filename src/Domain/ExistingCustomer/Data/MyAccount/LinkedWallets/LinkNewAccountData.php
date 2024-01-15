<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Data\MyAccount\LinkedWallets;

final class LinkNewAccountData
{
    public static function toArray(string $phone_number, string $network_resource): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'LinkedAccount',

                // Resource exposed attributes
                'attributes' => [
                    'phone_number' => $phone_number,
                    'network_resource' => $network_resource,
                ],
            ],
        ];
    }
}
