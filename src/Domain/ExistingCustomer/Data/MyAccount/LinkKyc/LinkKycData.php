<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Data\MyAccount\LinkKyc;

final class LinkKycData
{
    public static function toArray(string $id_number): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Kycs',

                // Resource exposed attributes
                'attributes' => [
                    'id_number' => $id_number,
                ],
            ],
        ];
    }
}
