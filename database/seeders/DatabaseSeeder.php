<?php

namespace Database\Seeders;

use Database\Seeders\Shared\ProductTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(class: ProductTableSeeder::class);
    }
}
