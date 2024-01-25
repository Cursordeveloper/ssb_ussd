<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Data\MyAccount\LinkNewWallet;

final class LinkNewAccountApprovalData
{
    public static function toArray(string $account_number, string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'LinkedAccount',

                // Resource exposed attributes
                'attributes' => [
                    'account_number' => $account_number,
                    'pin' => $pin,
                ],
            ],
        ];
    }
}
