<?php

declare(strict_types=1);

namespace App\Services\Susu\Data\BizSusu\Collection\Pause;

final class SusuServiceBizSusuCollectionPauseData
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
