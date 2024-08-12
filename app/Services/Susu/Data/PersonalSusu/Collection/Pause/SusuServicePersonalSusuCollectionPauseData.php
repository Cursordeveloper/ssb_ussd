<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\PersonalSusu\Collection\Pause;

final class SusuServicePersonalSusuCollectionPauseData
{
    public static function toArray(array $user_inputs): array
    {
        return [
            'data' => [
                // Resource type and id
                'type' => 'AccountPause',

                // Resource exposed attributes
                'attributes' => [
                    'duration' => $user_inputs['duration'],
                    'accepted_terms' => true,
                ],
            ],
        ];
    }
}
