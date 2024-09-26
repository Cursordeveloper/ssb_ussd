<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Collection\Pause;

final class SusuServiceBizSusuCollectionPauseCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'AccountPause',
            ],
        ];
    }
}
