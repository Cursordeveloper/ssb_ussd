<?php

declare(strict_types=1);

namespace App\States\StateManager;

use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\AboutInsuranceState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceClaims\AboutInsuranceClaimsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCommissions\AboutInsuranceCommissionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceContributions\AboutInsuranceContributionsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceCoverage\AboutInsuranceCoverageState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePayouts\AboutInsurancePayoutsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsurancePremiums\AboutInsurancePremiumsState;
use App\States\ExistingCustomer\Insurance\AboutInsurance\InsuranceSchemes\AboutInsuranceSchemesState;
use App\States\ExistingCustomer\Insurance\CreateInsurance\CreateInsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Insurance\InsuranceTerms\InsuranceTermsState;
use App\States\ExistingCustomer\Insurance\MyInsuranceAccounts\InsuranceAccount\InsuranceBalance\InsuranceBalanceState;
use App\States\ExistingCustomer\Insurance\MyInsuranceAccounts\MyInsuranceAccountsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use App\States\ExistingCustomer\Investments\AboutInvestment\InvestmentCommissions\InvestmentCommissionsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\InvestmentContributions\InvestmentContributionsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\InvestmentReturns\InvestmentReturnsState;
use App\States\ExistingCustomer\Investments\AboutInvestment\InvestmentSchemes\InvestmentSchemesState;
use App\States\ExistingCustomer\Investments\AboutInvestment\InvestmentWithdrawals\InvestmentWithdrawalsState;
use App\States\ExistingCustomer\Investments\CreateInvestment\StartInvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentTerms\InvestmentTermsState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\InvestmentAccount\InvestmentBalance\MyInvestmentBalanceState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\InvestmentAccount\InvestmentSettlement\MyInvestmentSettlementState;
use App\States\ExistingCustomer\Investments\MyInvestmentAccounts\MyInvestmentsState;
use App\States\ExistingCustomer\Loans\AboutLoans\AboutLoansState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanApplication\AboutLoanApplicationState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanCollateral\AboutLoanCollateralState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanDisbursements\AboutLoanDisbursementsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanInterests\AboutLoanInterestsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanQualification\AboutLoanQualificationState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanRepayments\AboutLoanRepaymentsState;
use App\States\ExistingCustomer\Loans\AboutLoans\LoanSchemes\AboutLoanSchemesState;
use App\States\ExistingCustomer\Loans\GetLoan\BizSusuLoan\BizSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\GetLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\PersonalSusuLoan\PersonalSusuLoanState;
use App\States\ExistingCustomer\Loans\GetLoan\SwiftCredit\SwiftCreditState;
use App\States\ExistingCustomer\Loans\LoanState;
use App\States\ExistingCustomer\Loans\LoanTerms\LoanTermsState;
use App\States\ExistingCustomer\Loans\MyLoans\LoanAccount\LoanBalance\MyLoanBalanceState;
use App\States\ExistingCustomer\Loans\MyLoans\LoanAccount\LoanPayment\MyLoanPaymentState;
use App\States\ExistingCustomer\Loans\MyLoans\MyLoansState;
use App\States\ExistingCustomer\MyAccount\ChangePin\ChangePinState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWallet\LinkedWalletState;
use App\States\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\MyAccount\LinkKyc\LinkIDCardState;
use App\States\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletState;
use App\States\ExistingCustomer\MyAccount\MyAccountState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionBenefits\AboutPensionBenefitsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionCommissions\AboutPensionCommissionsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionContributions\AboutPensionContributionsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionPayouts\AboutPensionPayoutsState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionSchemes\AboutPensionSchemesState;
use App\States\ExistingCustomer\Pension\AboutPension\AboutPensionState;
use App\States\ExistingCustomer\Pension\CreatePension\StartPensionState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\MyPensionsState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\PensionAccount\PensionBalance\PensionBalanceState;
use App\States\ExistingCustomer\Pension\MyPensionAccounts\PensionAccount\PensionClaims\PensionClaimsState;
use App\States\ExistingCustomer\Pension\PensionState;
use App\States\ExistingCustomer\Pension\PensionTerms\PensionTermsState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuCollections\AboutSusuCollectionsState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuFeesCharges\AboutSusuFeesChargesState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuSchemes\AboutSusuSchemesState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuWithdrawals\AboutSusuWithdrawalsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu\BizSusuAccountPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu\BizSusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu\BizSusuAccountWithdrawalState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\FlexySusu\FlexySusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\FlexySusuAccountWithdrawalState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\GoalGetterSusuAccountLiquidationState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\GoalGetterSusu\GoalGetterSusuAccountState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountPauseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountState;
use App\States\ExistingCustomer\Susu\StartSusu\CreateBizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\CreateFlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\StartSusu\CreateGoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\StartSusu\StartSusuState;
use App\States\ExistingCustomer\Susu\SusuState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use App\States\NewCustomer\NewCustomerState;
use App\States\NewCustomer\Registration\RegistrationState;
use App\States\NewCustomer\TermsAndConditions\TermsAndConditionsState;
use App\States\Shared\AboutSusubox\AboutSusuboxState;
use Domain\Shared\States\Susu\Balance\SusuAccountBalanceState;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Domain\Susu\PersonalSusu\States\Collection\PersonalSusuCollectionSummaryState;
use Domain\Susu\PersonalSusu\States\Payment\PersonalSusuPaymentState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementAllPendingState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementPendingState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementZeroOutState;
use Domain\Susu\PersonalSusu\States\Susu\PersonalSusuCreateState;
use Domain\Susu\Shared\States\SusuMiniStatementState;

final class StateClasses
{
    public static function execute(): array
    {
        return [
            // NewCustomerState (Options: RegistrationState, AboutSusuboxState, TermsAndConditionsState)
            class_basename(new NewCustomerState) => new NewCustomerState,


            // NewCustomerState
            class_basename(new RegistrationState) => new RegistrationState,
            class_basename(new AboutSusuboxState) => new AboutSusuboxState,
            class_basename(new TermsAndConditionsState) => new TermsAndConditionsState,


            // ExistingCustomerState (Options: SusuState, LoanState, InvestmentState, InsuranceState, PensionState)
            class_basename(new ExistingCustomerState) => new ExistingCustomerState,


            // SusuState (Options: MySusuAccountsState, StartSusuState, AboutSusuState, SusuTermsState)
            class_basename(new SusuState) => new SusuState,

            // SusuState
            class_basename(new MySusuAccountsState) => new MySusuAccountsState,
            class_basename(new StartSusuState) => new StartSusuState,
            class_basename(new AboutSusuState) => new AboutSusuState,
            class_basename(new SusuTermsState) => new SusuTermsState,

            // MySusuAccountsState (Options: SusuAccountState)
            class_basename(new SusuAccountState) => new SusuAccountState,

            // PersonalSusuAccountState (Options: MySusuAccountsState)
            class_basename(new PersonalSusuAccountState) => new PersonalSusuAccountState,
            class_basename(new PersonalSusuPaymentState) => new PersonalSusuPaymentState,
            class_basename(new PersonalSusuSettlementState) => new PersonalSusuSettlementState,

            // PersonalSusuSettlements
            class_basename(new PersonalSusuSettlementPendingState) => new PersonalSusuSettlementPendingState,
            class_basename(new PersonalSusuSettlementAllPendingState) => new PersonalSusuSettlementAllPendingState,
            class_basename(new PersonalSusuSettlementZeroOutState) => new PersonalSusuSettlementZeroOutState,

            // PersonalSusu collection states
            class_basename(new PersonalSusuCollectionSummaryState) => new PersonalSusuCollectionSummaryState,






            // BizSusuAccountState (Options: MySusuAccountsState)
            class_basename(new BizSusuAccountState) => new BizSusuAccountState,
            class_basename(new BizSusuAccountPaymentState) => new BizSusuAccountPaymentState,
            class_basename(new BizSusuAccountWithdrawalState) => new BizSusuAccountWithdrawalState,

            // GoalGetterSusuAccountState (Options: MySusuAccountsState)
            class_basename(new GoalGetterSusuAccountState) => new GoalGetterSusuAccountState,
            class_basename(new GoalGetterSusuAccountLiquidationState) => new GoalGetterSusuAccountLiquidationState,

            // FlexySusuAccountState (Options: MySusuAccountsState)
            class_basename(new FlexySusuAccountState) => new FlexySusuAccountState,
            class_basename(new FlexySusuAccountPaymentState) => new FlexySusuAccountPaymentState,
            class_basename(new FlexySusuAccountWithdrawalState) => new FlexySusuAccountWithdrawalState,

            // SusuAccountState shared (Options)
            class_basename(new SusuAccountBalanceState) => new SusuAccountBalanceState,
            class_basename(new SusuAccountPauseState) => new SusuAccountPauseState,
            class_basename(new SusuAccountCloseState) => new SusuAccountCloseState,

            // StartSusuState (Options)
            class_basename(new PersonalSusuCreateState) => new PersonalSusuCreateState,
            class_basename(new CreateBizSusuState) => new CreateBizSusuState,
            class_basename(new CreateGoalGetterSusuState) => new CreateGoalGetterSusuState,
            class_basename(new CreateFlexySusuState) => new CreateFlexySusuState,

            // AboutSusuStates (Options)
            class_basename(new AboutSusuSchemesState) => new AboutSusuSchemesState,
            class_basename(new AboutSusuCollectionsState) => new AboutSusuCollectionsState,
            class_basename(new AboutSusuWithdrawalsState) => new AboutSusuWithdrawalsState,
            class_basename(new AboutSusuFeesChargesState) => new AboutSusuFeesChargesState,




            // LoanState (Options: MyLoansState, GetLoanState, AboutLoansState, LoanTermsState)
            class_basename(new LoanState) => new LoanState,

            // LoanState
            class_basename(new MyLoansState) => new MyLoansState,
            class_basename(new GetLoanState) => new GetLoanState,
            class_basename(new AboutLoansState) => new AboutLoansState,
            class_basename(new LoanTermsState) => new LoanTermsState,

            // MyLoansState (Options: MyLoanState)
            //class_basename(new MyLoanState) => new MyLoanState,

            // MyLoanState (Options)
            class_basename(new MyLoanPaymentState) => new MyLoanPaymentState,
            class_basename(new MyLoanBalanceState) => new MyLoanBalanceState,

            // GetLoanState (Options)
            class_basename(new PersonalSusuLoanState) => new PersonalSusuLoanState,
            class_basename(new BizSusuLoanState) => new BizSusuLoanState,
            class_basename(new SwiftCreditState) => new SwiftCreditState,

            // AboutLoansState (Options)
            class_basename(new AboutLoanSchemesState) => new AboutLoanSchemesState,
            class_basename(new AboutLoanQualificationState) => new AboutLoanQualificationState,
            class_basename(new AboutLoanApplicationState) => new AboutLoanApplicationState,
            class_basename(new AboutLoanCollateralState) => new AboutLoanCollateralState,
            class_basename(new AboutLoanDisbursementsState) => new AboutLoanDisbursementsState,
            class_basename(new AboutLoanRepaymentsState) => new AboutLoanRepaymentsState,
            class_basename(new AboutLoanInterestsState) => new AboutLoanInterestsState,




            // InvestmentState (Options: MyInvestmentAccountsState, CreateInvestmentState, AboutInvestmentState, InvestmentTermsState)
            class_basename(new InvestmentState) => new InvestmentState,

            // InvestmentState
            class_basename(new MyInvestmentsState) => new MyInvestmentsState,
            class_basename(new StartInvestmentState) => new StartInvestmentState,
            class_basename(new AboutInvestmentState) => new AboutInvestmentState,
            class_basename(new InvestmentTermsState) => new InvestmentTermsState,

            // MyInvestmentsState (Options: MyInvestmentState)
            // class_basename(new MyInvestmentState) => new MyInvestmentState,

            // MyInvestmentState (Options)
            class_basename(new MyInvestmentBalanceState) => new MyInvestmentBalanceState,
            class_basename(new MyInvestmentSettlementState) => new MyInvestmentSettlementState,

            // StartInvestmentState (Options)
            // class_basename(new StartSusuInvestState) => new StartSusuInvestState,
            // class_basename(new StartSusuFundState) => new StartSusuFundState,

            // AboutInvestmentState (Options)
            class_basename(new InvestmentSchemesState) => new InvestmentSchemesState,
            class_basename(new InvestmentContributionsState) => new InvestmentContributionsState,
            class_basename(new InvestmentReturnsState) => new InvestmentReturnsState,
            class_basename(new InvestmentWithdrawalsState) => new InvestmentWithdrawalsState,
            class_basename(new InvestmentCommissionsState) => new InvestmentCommissionsState,




            // InsuranceState (Options: MyInsuranceAccountsState, CreateInsuranceState, AboutInsuranceState, InsuranceTermsState)
            class_basename(new InsuranceState) => new InsuranceState,

            // InsuranceState
            class_basename(new MyInsuranceAccountsState) => new MyInsuranceAccountsState,
            class_basename(new CreateInsuranceState) => new CreateInsuranceState,
            class_basename(new AboutInsuranceState) => new AboutInsuranceState,
            class_basename(new InsuranceTermsState) => new InsuranceTermsState,

            // MyInsuranceAccountsState (Options: MyInsuranceState)
            // class_basename(new MyInsuranceState) => new MyInsuranceState,

            // MyInsuranceState (Options)
            class_basename(new InsuranceBalanceState) => new InsuranceBalanceState,

            // AboutInsuranceState (Options)
            class_basename(new AboutInsuranceSchemesState) => new AboutInsuranceSchemesState,
            class_basename(new AboutInsuranceCoverageState) => new AboutInsuranceCoverageState,
            class_basename(new AboutInsurancePremiumsState) => new AboutInsurancePremiumsState,
            class_basename(new AboutInsuranceContributionsState) => new AboutInsuranceContributionsState,
            class_basename(new AboutInsuranceClaimsState) => new AboutInsuranceClaimsState,
            class_basename(new AboutInsurancePayoutsState) => new AboutInsurancePayoutsState,
            class_basename(new AboutInsuranceCommissionsState) => new AboutInsuranceCommissionsState,




            // PensionState (Options: MyPensionAccountsState, CreatePensionState, AboutPensionState, PensionTermsState)
            class_basename(new PensionState) => new PensionState,

            // PensionState
            class_basename(new MyPensionsState) => new MyPensionsState,
            class_basename(new StartPensionState) => new StartPensionState,
            class_basename(new AboutPensionState) => new AboutPensionState,
            class_basename(new PensionTermsState) => new PensionTermsState,

            // MyPensionsState (Options: MyPensionState)
            // class_basename(new MyPensionState) => new MyPensionState,

            // MyPensionState (Options: PensionBalanceState, PensionClaimsState)
            class_basename(new PensionBalanceState) => new PensionBalanceState,
            class_basename(new PensionClaimsState) => new PensionClaimsState,

            // AboutPensionState (Options)
            class_basename(new AboutPensionSchemesState) => new AboutPensionSchemesState,
            class_basename(new AboutPensionBenefitsState) => new AboutPensionBenefitsState,
            class_basename(new AboutPensionGuaranteesState) => new AboutPensionGuaranteesState,
            class_basename(new AboutPensionContributionsState) => new AboutPensionContributionsState,
            class_basename(new AboutPensionPayoutsState) => new AboutPensionPayoutsState,
            class_basename(new AboutPensionCommissionsState) => new AboutPensionCommissionsState,




            // MyAccountState (Options: LinkedWalletsState, LinkNewWalletState)
            class_basename(new MyAccountState) => new MyAccountState,

            // MyAccountState (Options)
            class_basename(new LinkedWalletsState) => new LinkedWalletsState,
            class_basename(new LinkNewWalletState) => new LinkNewWalletState,
            class_basename(new LinkIDCardState) => new LinkIDCardState,
            class_basename(new ChangePinState) => new ChangePinState,

            // LinkedWalletState
            class_basename(new LinkedWalletState) => new LinkedWalletState,

            // Susu shared states
            class_basename(new SusuMiniStatementState) => new SusuMiniStatementState,
        ];
    }
}
