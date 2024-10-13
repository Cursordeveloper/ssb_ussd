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

        DB::table(table: 'policy_contents')->insert([
            ['policy_id' => 1, 'text' => 'SusuBox is approved by the Bank of Ghana, ensuring compliance, credibility, and customer trust.'],
            ['policy_id' => 1, 'text' => 'SusuBox modernizes traditional susu savings with a cashless solution for convenience and security.'],
            ['policy_id' => 1, 'text' => 'Offers customized susu schemes for individuals, groups, businesses, and bill payments.'],
            ['policy_id' => 1, 'text' => 'SusuBox provides savings options for both short and long-term financial goals.'],
            ['policy_id' => 1, 'text' => 'Focuses on financial empowerment, promoting self-sufficiency and economic stability.'],
            ['policy_id' => 1, 'text' => 'SusuBox user-friendly channels include USSD, mobile apps, and web apps for easy management.'],
            ['policy_id' => 1, 'text' => 'Ensures fund safety with transparent accounting and reduced cash-handling risks.'],
            ['policy_id' => 1, 'text' => 'Provides a streamlined approach for users to achieve financial stability and confidence.'],
            ['policy_id' => 1, 'text' => 'Customers enjoy enhanced security, transparency, and ease of use, setting new financial standards.'],

            ['policy_id' => 2, 'text' => 'SusuBox provides digital savings services, allowing customers to save and contribute funds online.'],
            ['policy_id' => 2, 'text' => 'Customers can make contributions via mobile money or other payment methods and access variety of products.'],
            ['policy_id' => 2, 'text' => 'Customer must be 18 years or older to use SusuBox, ensuring compliance with age-related legal requirements.'],
            ['policy_id' => 2, 'text' => 'Access to a mobile money account or other supported payment methods is essential for savings and investment.'],
            ['policy_id' => 2, 'text' => 'Customers must follow all regulatory and legal guidelines set by SusuBox and financial authorities for platform use.'],
            ['policy_id' => 2, 'text' => 'Accurate personal information such as name, phone number and contact details must be provided during registration.'],
            ['policy_id' => 2, 'text' => 'Customers are required to link their Ghana Card to their SusuBox account.'],
            ['policy_id' => 2, 'text' => 'Agreement to SusuBox terms and conditions and other applicable agreements is mandatory for all customers.'],
            ['policy_id' => 2, 'text' => 'A valid mobile money wallet or other funding source is required for creating any of the SusuBox accounts.'],
            ['policy_id' => 2, 'text' => 'Customers must sign up via the SusuBox USSD, mobile app or website, and verify their contact information for security.'],
            ['policy_id' => 2, 'text' => 'Customers must make an initial deposit to activate their account and start accessing savings, loans and investment services.'],
            ['policy_id' => 2, 'text' => 'Contributions for savings are automatically deducted from the linked account based on the selected frequency.'],
            ['policy_id' => 2, 'text' => 'By using SusuBox, customers agree to review and follow the platform terms and conditions regularly to stay informed.'],
        ]);
    }
}
