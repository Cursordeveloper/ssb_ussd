<?php

declare(strict_types=1);

namespace Domain\Shared\Data\Common;

final class PinApprovalData
{
    public static function toArray(string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Pin',

                // Resource exposed attributes
                'attributes' => ['pin' => $pin],
            ],
        ];
    }
}
