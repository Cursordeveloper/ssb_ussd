<?php

namespace Database\Seeders;

use Database\Seeders\Shared\PolicyContentTableSeeder;
use Database\Seeders\Shared\PolicyTableSeeder;
use Database\Seeders\Shared\ProductTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(class: ProductTableSeeder::class);
        $this->call(class: PolicyTableSeeder::class);
        $this->call(class: PolicyContentTableSeeder::class);
    }
}
