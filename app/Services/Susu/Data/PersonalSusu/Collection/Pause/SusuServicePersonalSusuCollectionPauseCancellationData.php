<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Collection\Pause;

final class SusuServicePersonalSusuCollectionPauseCancellationData
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
