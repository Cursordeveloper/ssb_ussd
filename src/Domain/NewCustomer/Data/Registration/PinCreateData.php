<?php

declare(strict_types=1);

namespace Domain\NewCustomer\Data\Registration;

final class PinCreateData
{
    public static function toArray(string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Pin',

                // Resource exposed attributes
                'attributes' => [
                    'pin' => $pin,
                    'pin_confirmation' => $pin,
                ],
            ],
        ];
    }
}
