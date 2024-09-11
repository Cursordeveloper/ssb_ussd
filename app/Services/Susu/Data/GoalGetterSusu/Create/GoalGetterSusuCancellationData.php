<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\GoalGetterSusu\Create;

final class GoalGetterSusuCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type
                'type' => 'GoalGetterSusu',
            ],
        ];
    }
}
