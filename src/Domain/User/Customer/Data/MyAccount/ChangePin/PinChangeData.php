<?php

declare(strict_types=1);

namespace Domain\User\Customer\Data\MyAccount\ChangePin;

final class PinChangeData
{
    public static function toArray(string $current_pin, string $new_pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Pin',

                // Resource exposed attributes
                'attributes' => [
                    'pin' => $current_pin,
                    'new_pin' => $new_pin,
                    'new_pin_confirmation' => $new_pin,
                ],
            ],
        ];
    }
}
