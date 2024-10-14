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

            ['policy_id' => 2, 'text' => 'By creating a SusuBox account, you agree to the Terms. Disagree? Discontinue use.'],
            ['policy_id' => 2, 'text' => 'SusuBox: A platform offering susu savings models like Personal, Biz, Goal Getter, Flexy Susu.'],
            ['policy_id' => 2, 'text' => 'Customer: Any individual, group or entity using the SusuBox platform.'],
            ['policy_id' => 2, 'text' => 'Account: The digital profile customers create on SusuBox to access services.'],
            ['policy_id' => 2, 'text' => 'You must be 18+ and legally able to contract to use SusuBox.'],
            ['policy_id' => 2, 'text' => 'You are responsible for keeping your SusuBox account info secure.'],
            ['policy_id' => 2, 'text' => 'Transaction Fees: Customers do not pay third-party fees like mobile money or bank charges.'],
            ['policy_id' => 2, 'text' => 'Withdraw or settle from unlocked accounts anytime, with a fee.'],
            ['policy_id' => 2, 'text' => 'Withdrawals or settlements from locked accounts only after the lock period ends.'],
            ['policy_id' => 2, 'text' => 'Pause Collection feature lets customers pause mobile money debits.'],
            ['policy_id' => 2, 'text' => 'SusuBox supports mobile money from all networks for flexibility.'],
            ['policy_id' => 2, 'text' => 'We protect your privacy per our Privacy Policy'],
            ['policy_id' => 2, 'text' => 'SusuBox may suspend or terminate accounts for violations or fraud.'],
            ['policy_id' => 2, 'text' => 'SusuBox is not liable for indirect damages like lost savings or missed goals.'],
            ['policy_id' => 2, 'text' => 'Disputes resolved through negotiation or laws of Ghana.'],
            ['policy_id' => 2, 'text' => 'Terms governed by the laws of Ghana; disputes resolved in that jurisdiction.'],
            ['policy_id' => 2, 'text' => 'SusuBox may modify Terms, and continued use implies acceptance.'],
            ['policy_id' => 2, 'text' => 'Contact us: support@susubox.com or +123456789 for inquiries.'],
            ['policy_id' => 2, 'text' => 'By using SusuBox, you agree to these Terms and Conditions. Thank you!'],
        ]);
    }
}
