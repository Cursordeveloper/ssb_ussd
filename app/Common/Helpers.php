<?php

declare(strict_types=1);

namespace App\Common;

final class Helpers
{
    public static function formatPhoneNumber($phone_number): string
    {
        return substr_replace($phone_number, '0', 0, 3);
    }

    public static function arrayIndex(array $array): array
    {
        $adjustedArray = [];

        foreach ($array as $index => $value) {
            $adjustedIndex = $index + 1;
            $adjustedArray[$adjustedIndex] = $value;
        }

        return $adjustedArray;
    }
}
