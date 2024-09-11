<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Create;

final class PersonalSusuCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type
                'type' => 'PersonalSusu',
            ],
        ];
    }
}
