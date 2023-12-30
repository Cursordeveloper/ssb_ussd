<?php

declare(strict_types=1);

namespace App\States;

use App\Menus\ExistingCustomer\Loan\AboutLoans\AboutLoansMenu;
use App\Menus\ExistingCustomer\Loan\LoanBalance\LoanBalanceMenu;
use App\Menus\Shared\GeneralMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceState;
use App\States\ExistingCustomer\Insurance\Accounts\InsuranceAccountsState;
use App\States\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceBalance\InsuranceBalanceState;
use App\States\ExistingCustomer\Insurance\InsuranceClaims\InsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use App\States\ExistingCustomer\Investments\Accounts\InvestmentAccountsState;
use App\States\ExistingCustomer\Investments\CreateInvestment\CreateInvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentBalance\InvestmentBalanceState;
use App\States\ExistingCustomer\Investments\InvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentTerms\InvestmentTermsState;
use App\States\ExistingCustomer\Investments\InvestmentWithdrawal\InvestmentWithdrawalState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\LoanPayment\LoanPaymentState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\CheckBalance\CheckSusuBalanceState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\CreateSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\Settlement\SettlementState;
use App\States\ExistingCustomer\Susu\SusuPayment\SusuPaymentState;
use App\States\ExistingCustomer\Susu\SusuState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use App\States\NewCustomer\AboutSusubox\AboutSusuboxState;
use App\States\NewCustomer\NewCustomerState;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;
use App\States\Welcome\WelcomeState;
use Domain\Shared\Action\SessionCreateAction;
use Domain\Shared\Action\SessionGetAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StateManager
{
    public static function execute($state_data): JsonResponse
    {
        // Check if the type is "initiation"
        if ($state_data->new_session) {
            // Create session
            $session = SessionCreateAction::execute($state_data, state: 'WelcomeState');

            // Return the WelcomeState
            return WelcomeState::execute(session: $session);
        }

        // Define the states array
        $states = [
            // New customer states
            'NewCustomerState' => new NewCustomerState,
            'RegistrationState' => new RegistrationState,
            'TermsAndConditionsState' => new TermsAndConditionsState,
            'AboutSusuboxState' => new AboutSusuboxState,

            // Existing customer states
            'ExistingCustomerState' => new ExistingCustomerState,
            'SusuState' => new SusuState,
            'LoanState' => new LoanState,
            'InvestmentState' => new InvestmentState,
            'InsuranceState' => new InsuranceState,
            'MyAccountState' => new MyAccountState,

            // SusuState options
            'MySusuAccountsState' => new MySusuAccountsState,
            'CreateSusuState' => new CreateSusuState,
            'CheckSusuBalanceState' => new CheckSusuBalanceState,
            'SusuPaymentState' => new SusuPaymentState,
            'AboutSusuState' => new AboutSusuState,
            'SusuTermsState' => new SusuTermsState,
            'SettlementState' => new SettlementState,

            // Loan State(s)
            'GetLoanState' => new GetLoanState,
            'LoanPaymentState' => new LoanPaymentState,
            'LoanBalanceMenu' => new LoanBalanceMenu,
            'AboutLoansMenu' => new AboutLoansMenu,
            'LoanTermsState' => new LoanTermsState,

            // Investment State(s)
            'InvestmentAccountsState' => new InvestmentAccountsState,
            'CreateInvestmentState' => new CreateInvestmentState,
            'InvestmentBalanceState' => new InvestmentBalanceState,
            'AboutInvestmentState' => new AboutInvestmentState,
            'InvestmentTermsState' => new InvestmentTermsState,
            'InvestmentWithdrawalState' => new InvestmentWithdrawalState,

            // Insurance State(s)
            'InsuranceAccountsState' => new InsuranceAccountsState,
            'CreateInsuranceState' => new CreateInsuranceState,
            'InsuranceBalanceState' => new InsuranceBalanceState,
            'AboutInsuranceState' => new AboutInsuranceState,
            'InsuranceTermsState' => new InsuranceTermsState,
            'InsuranceClaimsState' => new InsuranceClaimsState,

            // MyAccountState options
            'LinkedWalletsState' => new LinkedWalletsState,
            'LinkNewWalletState' => new LinkNewWalletState,
            'ChangePinState' => new ChangePinState,

            // CreateNewSusuState options
            'CreatePersonalSusuState' => new CreatePersonalSusuState,
            'CreateBizSusuState' => new CreateBizSusuState,
            'CreateGoalGetterSusuState' => new CreateGoalGetterSusuState,
            'CreateFlexySusuState' => new CreateFlexySusuState,
        ];

        // Get the session
        $session = SessionGetAction::execute(session_id: $state_data->session_id);
        $customer_session = data_get(target: $session, key: 'state');

        // Execute the state if it exists in the $states array
        if (array_key_exists($customer_session, $states)) {
            // Return the state menu
            return $states[$customer_session]::execute($session, $state_data);
        }

        // Return a system failure message.
        return GeneralMenu::invalidInput(session: $session);
    }
}
