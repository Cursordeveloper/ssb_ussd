<?php

declare(strict_types=1);

namespace App\Common;

final class Helpers
{
    public static function Phone($phone_number): string {
        return substr_replace($phone_number, "0", 0, 3);
    }
}
