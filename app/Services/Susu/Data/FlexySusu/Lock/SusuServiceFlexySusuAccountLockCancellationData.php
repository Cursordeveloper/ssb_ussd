<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Lock;

final class SusuServiceFlexySusuAccountLockCancellationData
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
