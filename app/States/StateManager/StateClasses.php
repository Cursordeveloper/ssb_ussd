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
use App\States\ExistingCustomer\Loans\GetLoan\BizSusuLoan\BizSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\PersonalSusuLoan\PersonalSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\SwiftCredit\SwiftCreditState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\LoanAccount\LoanBalance\LoanBalanceState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\LoanAccount\LoanPayment\LoanPaymentState;
use App\States\ExistingCustomer\Loans\MyLoanAccounts\MyLoanAccountsState;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet\LinkedWalletState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkKyc\LinkKycState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionState;
use App\States\ExistingCustomer\Pension\CreatePension\CreatePensionState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\MyPensionAccountsState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\PensionAccount\PensionBalance\PensionBalanceState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\PensionAccount\PensionClaims\PensionClaimsState;
use App\States\ExistingCustomer\Pension\PensionState;
use App\States\ExistingCustomer\Pension\PensionTerms\PensionTermsState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\AboutSusu\FeesCharges\FeesChargesState;
use App\States\ExistingCustomer\Susu\AboutSusu\SettlementsWithdrawals\SusuWithdrawalsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuCollections\SusuCollectionsState;
use App\States\ExistingCustomer\Susu\AboutSusu\SusuSchemes\SusuSchemesState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance\SusuBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuCloseAccount\SusuCloseAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPauseAccount\SusuPauseAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment\SusuPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuWithdrawalState;
use App\States\ExistingCustomer\Susu\StartSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\StartSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\PersonalSusu\CreatePersonalSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\StartSusuState;
use App\States\ExistingCustomer\Susu\SusuState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use App\States\NewCustomer\NewCustomerState;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;
use App\States\Shared\AboutSusubox\AboutSusuboxState;

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
            'PensionState' => new PensionState,
            'MyAccountState' => new MyAccountState,

            // SusuState options
            'MySusuAccountsState' => new MySusuAccountsState,
            'StartSusuState' => new StartSusuState,
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
            'SusuWithdrawalsState' => new SusuWithdrawalsState,
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

            // GetLoanState (Child States)
            'PersonalSusuLoanState' => new PersonalSusuLoanState,
            'BizSusuLoanState' => new BizSusuLoanState,
            'SwiftCreditState' => new SwiftCreditState,

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

            // Pension State(s)
            'MyPensionAccountsState' => new MyPensionAccountsState,
            'CreatePensionState' => new CreatePensionState,
            'AboutPensionState' => new AboutPensionState,
            'PensionTermsState' => new PensionTermsState,

            // PensionAccount State(s)
            'PensionBalanceState' => new PensionBalanceState,
            'PensionClaimsState' => new PensionClaimsState,

            // MyAccountState options
            'LinkedWalletsState' => new LinkedWalletsState,
            'LinkNewWalletState' => new LinkNewWalletState,
            'LinkKycState' => new LinkKycState,
            'ChangePinState' => new ChangePinState,

            // CreateNewSusuState options
            'CreatePersonalSusuState' => new CreatePersonalSusuState,
            'CreateBizSusuState' => new CreateBizSusuState,
            'CreateGoalGetterSusuState' => new CreateGoalGetterSusuState,
            'CreateFlexySusuState' => new CreateFlexySusuState,
        ];
    }
}
