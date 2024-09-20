<?php

declare(strict_types=1);

namespace App\Services\Customer\Data\Kyc;

final class CustomerServiceLinkGhanaCardCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Kyc',
            ],
        ];
    }
}
