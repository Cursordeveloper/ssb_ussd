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
            'text' => 'SusuBox is approved by the Bank of Ghana, ensuring compliance, credibility, and customer trust.',
        ], [
            'policy_id' => 1,
            'text' => 'SusuBox modernizes traditional susu savings with a cashless solution for convenience and security.',
        ], [
            'policy_id' => 1,
            'text' => 'Offers customized susu schemes for individuals, groups, businesses, and bill payments.',
        ], [
            'policy_id' => 1,
            'text' => 'SusuBox provides savings options for both short- and long-term financial goals.',
        ], [
            'policy_id' => 1,
            'text' => 'Focuses on financial empowerment, promoting self-sufficiency and economic stability.',
        ], [
            'policy_id' => 1,
            'text' => 'SusuBox user-friendly channels include USSD, mobile apps, and web apps for easy management.',
        ], [
            'policy_id' => 1,
            'text' => 'Ensures fund safety with transparent accounting and reduced cash-handling risks.',
        ], [
            'policy_id' => 1,
            'text' => 'Provides a streamlined approach for users to achieve financial stability and confidence.',
        ], [
            'policy_id' => 1,
            'text' => 'Customers enjoy enhanced security, transparency, and ease of use, setting new financial standards.',
        ]]);
    }
}
