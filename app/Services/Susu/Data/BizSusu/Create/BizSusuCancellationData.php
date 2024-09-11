<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Create;

final class BizSusuCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource typ
                'type' => 'BizSusu',
            ],
        ];
    }
}
