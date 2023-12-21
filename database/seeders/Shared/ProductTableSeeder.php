<?php

namespace Database\Seeders\Shared;

use Database\Seeders\Shared\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    use TruncateTable;

    public function run(): void
    {
        $this->truncateTable(table: 'products');

        DB::table(table: 'products')->insert([[
            'resource_id' => '20aac17e-ff63-4d0d-96b3-49007925876f',
            'category' => 'susu',
            'order' => '1',
            'name' => 'Personal Susu',
        ], [
            'resource_id' => '06f8fdd0-8a33-4483-adfb-6643d1f5797d',
            'category' => 'susu',
            'order' => '2',
            'name' => 'Biz Susu',
        ], [
            'resource_id' => '805df9db-1f9b-4fac-979e-d00572807092',
            'category' => 'susu',
            'order' => '3',
            'name' => 'Goal Getter',
        ], [
            'resource_id' => '91b1b2af-a21b-43aa-8bd1-da23cf4340ba',
            'category' => 'susu',
            'order' => '4',
            'name' => 'Flexy Susu',
        ], [
            'resource_id' => '7f1d6072-7bcc-417e-b8ea-06a716660d55',
            'category' => 'susu',
            'order' => '5',
            'name' => 'Group Susu',
        ], [
            'resource_id' => '57aee8a8-f080-4ca1-8f1a-7fc6f07d62e4',
            'category' => 'susu',
            'order' => '6',
            'name' => 'Susu For Bills',
        ]]);
    }
}
