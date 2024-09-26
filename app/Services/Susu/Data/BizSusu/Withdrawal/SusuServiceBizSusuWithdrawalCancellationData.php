<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Withdrawal;

final class SusuServiceBizSusuWithdrawalCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuWithdrawal',
            ],
        ];
    }
}
