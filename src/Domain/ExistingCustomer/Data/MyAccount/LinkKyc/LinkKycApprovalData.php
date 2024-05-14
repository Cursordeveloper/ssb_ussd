<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Data\MyAccount\LinkKyc;

final class LinkKycApprovalData
{
    public static function toArray(string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Kyc',

                // Resource exposed attributes
                'attributes' => [
                    'pin' => $pin,
                ],
            ],
        ];
    }
}
