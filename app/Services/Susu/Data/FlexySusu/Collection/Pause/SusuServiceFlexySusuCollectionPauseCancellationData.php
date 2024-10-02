<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Collection\Pause;

final class SusuServiceFlexySusuCollectionPauseCancellationData
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
