<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\FlexySusu\Collection\Pause;

final class SusuServiceFlexySusuCollectionPauseData
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
