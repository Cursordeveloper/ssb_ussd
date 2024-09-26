<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Lock;

final class SusuServiceBizSusuAccountCancellationData
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
