<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Settlement;

final class SusuServicePersonalSusuSettlementData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'SusuSettlement',

                // Resource exposed attributes
                'attributes' => [
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
