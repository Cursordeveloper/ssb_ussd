<?php

declare(strict_types=1);

namespace Database\Seeders\Shared\Traits;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{
    protected function truncateTable($table): void
    {
        DB::table($table)->truncate();
    }
}
