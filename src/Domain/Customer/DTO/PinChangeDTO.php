<?php

declare(strict_types=1);

namespace Domain\Customer\DTO;

final class PinChangeDTO
{
    public static function toArray(string $current_pin, string $new_pin): array
    {
        return [
            // Resource type and id
            'type' => 'Pin',

            // Resource exposed attributes
            'attributes' => [
                'pin' => $current_pin,
                'new_pin' => $new_pin,
            ],
        ];
    }
}
