<?php

declare(strict_types=1);

namespace Domain\User\Customer\Data\MyAccount\LinkedWallet;

final class LinkWalletApprovalData
{
    public static function toArray(string $resource_id, string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'LinkedAccount',

                // Resource exposed attributes
                'attributes' => [
                    'resource_id' => $resource_id,
                    'pin' => $pin,
                ],
            ],
        ];
    }
}
