<?php

declare(strict_types=1);

namespace App\States\StateManager;

use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceState;
use App\States\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsState;
use App\States\ExistingCustomer\Insurance\MyInsuranceAccounts\InsuranceAccount\InsuranceBalance\InsuranceBalanceState;
use App\States\ExistingCustomer\Insurance\MyInsuranceAccounts\InsuranceAccount\InsuranceClaims\InsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\MyInsuranceAccounts\MyInsuranceAccountsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use App\States\ExistingCustomer\Investments\CreateInvestment\CreateInvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentTerms\InvestmentTermsState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\InvestmentAccount\InvestmentBalance\InvestmentBalanceState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\InvestmentAccount\InvestmentSettlement\InvestmentSettlementState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\MyInvestmentAccountsState;
use App\States\ExistingCustomer\Loans\AboutLoans\AboutLoansState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\LoanAccount\LoanBalance\LoanBalanceState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\LoanAccount\LoanPayment\LoanPaymentState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\MyLoanAccountsState;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet\LinkedWalletState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\AboutSusu\FeesCharges\FeesChargesState;
use App\States\ExistingCustomer\Susu\AboutSusu\SettlementsWithdrawals\SettlementsWithdrawalsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuCollections\SusuCollectionsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuSchemes\SusuSchemesState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\CreateSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance\SusuBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuCloseAccount\SusuCloseAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPauseAccount\SusuPauseAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment\SusuPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuWithdrawalState;
use App\States\ExistingCustomer\Susu\SusuState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use App\States\NewCustomer\AboutSusubox\AboutSusuboxState;
use App\States\NewCustomer\NewCustomerState;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;

final class StateClasses
{
    public static function execute(): array
    {
        return [
            // New customer states
            'NewCustomerState' => new NewCustomerState,
            'RegistrationState' => new RegistrationState,
            'AboutSusuboxState' => new AboutSusuboxState,
            'TermsAndConditionsState' => new TermsAndConditionsState,

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
            'AboutSusuState' => new AboutSusuState,
            'SusuTermsState' => new SusuTermsState,

            // SusuAccountState options
            'SusuAccountState' => new SusuAccountState,
            'SusuBalanceState' => new SusuBalanceState,
            'SusuPaymentState' => new SusuPaymentState,
            'SusuWithdrawalState' => new SusuWithdrawalState,
            'SusuPauseAccountState' => new SusuPauseAccountState,
            'SusuCloseAccountState' => new SusuCloseAccountState,

            // AboutSusuStates
            'SusuSchemesState' => new SusuSchemesState,
            'SusuCollectionsState' => new SusuCollectionsState,
            'SettlementsWithdrawalsState' => new SettlementsWithdrawalsState,
            'FeesChargesState' => new FeesChargesState,

            // LinkedWalletState
            'LinkedWalletState' => new LinkedWalletState,

            // Loan State(s)
            'MyLoanAccountsState' => new MyLoanAccountsState,
            'GetLoanState' => new GetLoanState,
            'AboutLoansState' => new AboutLoansState,
            'LoanTermsState' => new LoanTermsState,

            // MyLoansState(s)
            'LoanPaymentState' => new LoanPaymentState,
            'LoanBalanceState' => new LoanBalanceState,

            // Investment State(s)
            'MyInvestmentAccountsState' => new MyInvestmentAccountsState,
            'CreateInvestmentState' => new CreateInvestmentState,
            'AboutInvestmentState' => new AboutInvestmentState,
            'InvestmentTermsState' => new InvestmentTermsState,

            // InvestmentAccount State(s)
            'InvestmentBalanceState' => new InvestmentBalanceState,
            'InvestmentSettlementState' => new InvestmentSettlementState,

            // Insurance State(s)
            'MyInsuranceAccountsState' => new MyInsuranceAccountsState,
            'CreateInsuranceState' => new CreateInsuranceState,
            'AboutInsuranceState' => new AboutInsuranceState,
            'InsuranceTermsState' => new InsuranceTermsState,

            // InsuranceAccount State(s)
            'InsuranceBalanceState' => new InsuranceBalanceState,
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
    }
}
