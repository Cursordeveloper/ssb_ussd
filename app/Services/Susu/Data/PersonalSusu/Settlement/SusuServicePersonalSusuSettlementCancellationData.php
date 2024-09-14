<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Settlement;

final class SusuServicePersonalSusuSettlementCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuSettlement',
            ],
        ];
    }
}
