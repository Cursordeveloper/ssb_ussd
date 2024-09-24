<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Lock;

final class SusuServicePersonalSusuAccountLockCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'AccountLock',
            ],
        ];
    }
}
