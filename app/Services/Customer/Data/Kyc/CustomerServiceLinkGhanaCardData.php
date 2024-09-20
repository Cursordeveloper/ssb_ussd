<?php

declare(strict_types=1);

namespace App\Services\Customer\Data\Kyc;

final class CustomerServiceLinkGhanaCardData
{
    public static function toArray(string $id_number): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Kyc',

                // Resource exposed attributes
                'attributes' => [
                    'id_number' => $id_number,
                ],
            ],
        ];
    }
}
