<?php

declare(strict_types=1);

namespace Domain\Customer\DTO;

final class PinApprovalDTO
{
    public static function toArray(string $pin): array
    {
        return [
            // Resource type and id
            'type' => 'Pin',

            // Resource exposed attributes
            'attributes' => [
                'pin' => $pin,
            ],
        ];
    }
}
