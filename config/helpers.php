<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

function phone($phone_number): string {
    return substr_replace($phone_number, "0", 0, 3);
}
