<?php

declare(strict_types=1);

namespace App\Services\Customer\Data\LinkedAccount;

final class CustomerServiceLinkNewAccountCancellationData
{
    public static function toArray(): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'LinkedAccount',
            ],
        ];
    }
}
