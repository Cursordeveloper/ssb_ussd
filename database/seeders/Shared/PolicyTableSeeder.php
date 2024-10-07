<?php

namespace Database\Seeders\Shared;

use Database\Seeders\Shared\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PolicyTableSeeder extends Seeder
{
    use TruncateTable;

    public function run(): void
    {
        $this->truncateTable(table: 'policies');

        DB::table(table: 'policies')->insert([[
            'code' => 'about-susubox',
            'name' => 'About SusuBox',
            'url' => 'https://susubox.app/about-susubox',
        ], [
            'code' => 'terms-and-conditions',
            'name' => 'Terms and Conditions',
            'url' => 'https://susubox.app/terms-and-conditions',
        ]]);
    }
}
