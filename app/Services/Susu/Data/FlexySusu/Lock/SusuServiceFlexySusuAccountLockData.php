<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Lock;

final class SusuServiceFlexySusuAccountLockData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'AccountLock',

                // Resource exposed attributes
                'attributes' => [
                    'duration' => $user_inputs['duration'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
