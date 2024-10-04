<?php

namespace Database\Seeders\Shared;

use Database\Seeders\Shared\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PolicyContentTableSeeder extends Seeder
{
    use TruncateTable;

    public function run(): void
    {
        $this->truncateTable(table: 'policy_contents');

        DB::table(table: 'policy_contents')->insert([[
            'policy_id' => 1,
            'text' => 'Susubox modernizes the traditional susu savings system with a cashless solution, ensuring convenience and security.',
        ], [
            'policy_id' => 1,
            'text' => 'Offers customized susu schemes for individuals, groups, businesses, and bill payment needs.',
        ], [
            'policy_id' => 1,
            'text' => 'As a licensed platform, SusuBox operates under the regulatory framework of the Bank of Ghana, ensuring legal compliance, credibility, and customer trust.',
        ], [
            'policy_id' => 1,
            'text' => 'Leverages cutting-edge technology to modernize and secure susu collection, reducing risks linked to traditional methods.',
        ]]);
    }
}
