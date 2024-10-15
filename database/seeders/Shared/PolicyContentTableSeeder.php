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

        // About SusuBox
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
        ]);

        // Terms and Conditions
        DB::table(table: 'policy_contents')->insert([
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
            ['policy_id' => 2, 'text' => 'By using SusuBox, you agree to these Terms and Conditions.'],
        ]);

        // About Susu
        DB::table(table: 'policy_contents')->insert([
            ['policy_id' => 3, 'text' => 'SusuBox provides a comprehensive suite of susu schemes or models.'],
            ['policy_id' => 3, 'text' => 'The schemes are tailored to meet the diverse needs and preferences of customers.'],
            ['policy_id' => 3, 'text' => 'Designed to offer flexibility, convenience, and financial empowerment.'],
            ['policy_id' => 3, 'text' => 'Customers can create multiple susu accounts to organize savings for various goals and budgets.'],
            ['policy_id' => 3, 'text' => 'SusuBox provides seamless transactions, enabling easy monitoring of account activity and building trust.'],

            ['policy_id' => 3, 'text' => 'Personal Susu: Customers create a Susu savings account, with a name, and set a daily savings amount.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: SusuBox auto-deducts daily savings from the customer’s mobile wallet for 31 days.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: The platform ensures safe and secure savings for customers.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: After 31 days, customers can withdraw or auto-renew their savings.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: Retained savings build creditworthiness for loans.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: Customers choose automated or manual settlement after 31 days.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: Settlements are seamless and convenient.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: A one-day service fee applies within the 31-day cycle.'],
            ['policy_id' => 3, 'text' => 'Personal Susu: Customers can create multiple savings accounts for different goals.'],

            ['policy_id' => 3, 'text' => 'Biz Susu: Is tailored for small business owners, addressing their specific financial needs.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: Business owners can contribute daily, weekly, or monthly, aligning with their cash flow.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: Creating a BSS account is easy: name it, set a savings amount, and select a debit frequency.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: SusuBox automates collections, with a manual payment option if debits fail.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: The recurring debit option rolls over failed payments, encouraging consistent savings.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: SusuBox provides transparent, detailed reports of contributions and growth.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: Business owners can easily manage their accounts via the user-friendly platform.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: Accessing savings is streamlined for essential expenses or business growth.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: Withdrawals, subject to a 3.2% fee, are instantly transferred to the linked wallet.'],
            ['policy_id' => 3, 'text' => 'Biz Susu: BSS serves as a safety net, allowing withdrawals anytime for emergencies or opportunities.'],

            ['policy_id' => 3, 'text' => 'Goal Getter: GGS lets customers set precise savings goals, such as funding education or buying a car.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: Customers can choose savings durations from 6 to 5 years, tailored to their financial plans.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: SusuBox calculates the required savings to meet goals within the chosen duration.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: To create account provide goal, target amount, duration, and debit frequency.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: GGS enforces discipline with recurring debits, promoting consistent savings habits.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: GGS accounts are automatically locked to prevent withdrawals until the goal is achieved.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: Once the goal is reached, debits stop, and the account unlocks for withdrawal.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: GGS integrates with SusuBox services, allowing customers to use savings for investments, etc.'],
            ['policy_id' => 3, 'text' => 'Goal Getter: GGS provides secure, flexible savings that promote financial success and disciplined habits.'],

            ['policy_id' => 3, 'text' => 'Flexy Susu: Flexy Susu Savings lets customers save any amount and frequency to adapt to income changes.'],
            ['policy_id' => 3, 'text' => 'Flexy Susu: Account holders can make manual payments at any time, giving them control over their savings.'],
            ['policy_id' => 3, 'text' => 'Flexy Susu: Customers can lock their account to prevent withdrawals, with automatic unlocking afterward.'],
            ['policy_id' => 3, 'text' => 'Flexy Susu: Flexy Susu Savings allows unrestricted withdrawals anytime for easy access during emergencies.'],
            ['policy_id' => 3, 'text' => 'Flexy Susu: Customers can use savings as collateral for loans with flexible repayment terms.'],
        ]);
    }
}
