<?php

declare(strict_types=1);

namespace Domain\User\Customer\Data\MyAccount\LinkGhanaCard;

final class LinkGhanaCardApprovalData
{
    public static function toArray(string $pin): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'Pin',

                // Resource exposed attributes
                'attributes' => [
                    'pin' => $pin,
                ],
            ],
        ];
    }
}
