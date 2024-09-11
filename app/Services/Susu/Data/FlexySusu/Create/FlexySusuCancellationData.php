<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Create;

final class FlexySusuCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type
                'type' => 'FlexySusu',
            ],
        ];
    }
}
