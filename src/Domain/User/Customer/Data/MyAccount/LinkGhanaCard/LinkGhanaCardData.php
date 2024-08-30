<?php

declare(strict_types=1);

namespace Domain\User\Customer\Data\MyAccount\LinkGhanaCard;

final class LinkGhanaCardData
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
