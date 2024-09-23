<?php

declare(strict_types=1);

namespace Domain\Shared\States;

use Domain\Insurance\Shared\States\AboutInsurance\AboutInsuranceState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceClaims\AboutInsuranceClaimsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceCommissions\AboutInsuranceCommissionsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceContributions\AboutInsuranceContributionsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceCoverage\AboutInsuranceCoverageState;
use Domain\Insurance\Shared\States\AboutInsurance\InsurancePayouts\AboutInsurancePayoutsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsurancePremiums\AboutInsurancePremiumsState;
use Domain\Insurance\Shared\States\AboutInsurance\InsuranceSchemes\AboutInsuranceSchemesState;
use Domain\Insurance\Shared\States\Insurance\InsuranceState;
use Domain\Insurance\Shared\States\InsuranceTerms\InsuranceTermsState;
use Domain\Insurance\Shared\States\StartInsurance\StartInsuranceState;
use Domain\Investment\Shared\States\AboutInvestment\AboutInvestmentState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentCommissions\InvestmentCommissionsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentContributions\InvestmentContributionsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentReturns\InvestmentReturnsState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentSchemes\InvestmentSchemesState;
use Domain\Investment\Shared\States\AboutInvestment\InvestmentWithdrawals\InvestmentWithdrawalsState;
use Domain\Investment\Shared\States\Investment\InvestmentState;
use Domain\Investment\Shared\States\InvestmentTerms\InvestmentTermsState;
use Domain\Investment\Shared\States\StartInvestment\StartInvestmentState;
use Domain\Loan\BizSusuLoan\States\Account\BizSusuLoanAccountState;
use Domain\Loan\PersonalSusuLoan\States\Account\PersonalSusuLoanAccountState;
use Domain\Loan\Shared\States\AboutLoan\AboutLoansState;
use Domain\Loan\Shared\States\AboutLoan\LoanApplication\AboutLoanApplicationState;
use Domain\Loan\Shared\States\AboutLoan\LoanCollateral\AboutLoanCollateralState;
use Domain\Loan\Shared\States\AboutLoan\LoanDisbursement\AboutLoanDisbursementState;
use Domain\Loan\Shared\States\AboutLoan\LoanInterest\AboutLoanInterestState;
use Domain\Loan\Shared\States\AboutLoan\LoanQualification\AboutLoanQualificationState;
use Domain\Loan\Shared\States\AboutLoan\LoanRepayment\AboutLoanRepaymentState;
use Domain\Loan\Shared\States\AboutLoan\LoanSchemes\AboutLoanSchemesState;
use Domain\Loan\Shared\States\GetLoan\GetLoanState;
use Domain\Loan\Shared\States\Loan\LoanState;
use Domain\Loan\Shared\States\LoanBalance\LoanBalanceState;
use Domain\Loan\Shared\States\LoanTerms\LoanTermsState;
use Domain\Loan\SwiftLoan\States\Account\SwiftLoanAccountState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionBenefits\AboutPensionBenefitsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionCommissions\AboutPensionCommissionsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionContributions\AboutPensionContributionsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionGuarantees\AboutPensionGuaranteesState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionPayouts\AboutPensionPayoutsState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionSchemes\AboutPensionSchemesState;
use Domain\Pension\Shared\States\AboutPension\AboutPensionState;
use Domain\Pension\Shared\States\Pension\PensionState;
use Domain\Pension\Shared\States\PensionTerms\PensionTermsState;
use Domain\Pension\Shared\States\StartPension\StartPensionState;
use Domain\Shared\States\AboutSusuBox\AboutSusuboxState;
use Domain\Shared\States\TermsAndConditions\TermsAndConditionsState;
use Domain\Susu\BizSusu\States\Account\BizSusuAccountState;
use Domain\Susu\BizSusu\States\Collection\BizSusuCollectionState;
use Domain\Susu\BizSusu\States\Collection\Pause\BizSusuCollectionPauseState;
use Domain\Susu\BizSusu\States\Collection\Summary\BizSusuCollectionSummaryState;
use Domain\Susu\BizSusu\States\Create\BizSusuCreateState;
use Domain\Susu\BizSusu\States\Lock\BizSusuAccountLockState;
use Domain\Susu\BizSusu\States\Payment\BizSusuPaymentAmountState;
use Domain\Susu\BizSusu\States\Payment\BizSusuPaymentFrequencyState;
use Domain\Susu\BizSusu\States\Payment\BizSusuPaymentState;
use Domain\Susu\BizSusu\States\Withdrawal\BizSusuWithdrawalFullState;
use Domain\Susu\BizSusu\States\Withdrawal\BizSusuWithdrawalPartialState;
use Domain\Susu\BizSusu\States\Withdrawal\BizSusuWithdrawalState;
use Domain\Susu\FlexySusu\States\Account\FlexySusuAccountState;
use Domain\Susu\FlexySusu\States\Collection\FlexySusuCollectionState;
use Domain\Susu\FlexySusu\States\Collection\Pause\FlexySusuCollectionPauseState;
use Domain\Susu\FlexySusu\States\Create\FlexySusuCreateState;
use Domain\Susu\FlexySusu\States\Lock\FlexySusuAccountLockState;
use Domain\Susu\FlexySusu\States\Payment\FlexySusuPaymentState;
use Domain\Susu\FlexySusu\States\Withdrawal\FlexySusuWithdrawalFullState;
use Domain\Susu\FlexySusu\States\Withdrawal\FlexySusuWithdrawalPartialState;
use Domain\Susu\FlexySusu\States\Withdrawal\FlexySusuWithdrawalState;
use Domain\Susu\GoalGetterSusu\States\Account\GoalGetterSusuAccountState;
use Domain\Susu\GoalGetterSusu\States\Collection\Goal\GoalGetterSusuGoalSummaryState;
use Domain\Susu\GoalGetterSusu\States\Collection\GoalGetterSusuCollectionState;
use Domain\Susu\GoalGetterSusu\States\Collection\Summary\GoalGetterSusuCollectionSummaryState;
use Domain\Susu\GoalGetterSusu\States\Create\GoalGetterSusuCreateState;
use Domain\Susu\GoalGetterSusu\States\Payment\GoalGetterSusuPaymentAmountState;
use Domain\Susu\GoalGetterSusu\States\Payment\GoalGetterSusuPaymentFrequencyState;
use Domain\Susu\GoalGetterSusu\States\Payment\GoalGetterSusuPaymentState;
use Domain\Susu\GoalGetterSusu\States\Withdrawal\GoalGetterSusuWithdrawalFullState;
use Domain\Susu\GoalGetterSusu\States\Withdrawal\GoalGetterSusuWithdrawalPartialState;
use Domain\Susu\GoalGetterSusu\States\Withdrawal\GoalGetterSusuWithdrawalState;
use Domain\Susu\PersonalSusu\States\Account\PersonalSusuAccountState;
use Domain\Susu\PersonalSusu\States\Collection\Pause\PersonalSusuCollectionPauseState;
use Domain\Susu\PersonalSusu\States\Collection\PersonalSusuCollectionState;
use Domain\Susu\PersonalSusu\States\Collection\Summary\PersonalSusuCollectionSummaryState;
use Domain\Susu\PersonalSusu\States\Create\PersonalSusuCreateState;
use Domain\Susu\PersonalSusu\States\Lock\PersonalSusuAccountLockState;
use Domain\Susu\PersonalSusu\States\Payment\PersonalSusuPaymentState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementAllPendingState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementPendingState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementZeroOutState;
use Domain\Susu\Shared\States\AboutSusu\AboutSusuState;
use Domain\Susu\Shared\States\AboutSusu\SusuCollections\AboutSusuCollectionsState;
use Domain\Susu\Shared\States\AboutSusu\SusuFeesCharges\AboutSusuFeesChargesState;
use Domain\Susu\Shared\States\AboutSusu\SusuSchemes\AboutSusuSchemesState;
use Domain\Susu\Shared\States\AboutSusu\SusuWithdrawals\AboutSusuWithdrawalsState;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\StartSusu\StartSusuState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Domain\Susu\Shared\States\Susu\SusuState;
use Domain\Susu\Shared\States\SusuTerms\SusuTermsState;
use Domain\User\Customer\States\MyAccount\ChangePin\ChangePinState;
use Domain\User\Customer\States\MyAccount\LinkedWallet\LinkedWalletsState;
use Domain\User\Customer\States\MyAccount\LinkedWallet\LinkedWalletState;
use Domain\User\Customer\States\MyAccount\LinkedWallet\LinkNewWalletState;
use Domain\User\Customer\States\MyAccount\LinkGhanaCard\LinkGhanaCardState;
use Domain\User\Customer\States\MyAccount\MyAccountState;
use Domain\User\Customer\States\MyInsuranceAccounts\MyInsuranceAccountsState;
use Domain\User\Customer\States\MyInvestmentAccounts\MyInvestmentAccountsState;
use Domain\User\Customer\States\MyLoanAccounts\MyLoanAccountsState;
use Domain\User\Customer\States\MyPensionAccounts\MyPensionAccountsState;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Domain\User\Customer\States\Welcome\CustomerWelcomeState;
use Domain\User\Guest\States\Registration\RegistrationState;
use Domain\User\Guest\States\Welcome\GuestWelcomeState;

final class StateClasses
{
    public static function execute(): array
    {
        return [
            // Guest welcome states
            class_basename(new GuestWelcomeState) => new GuestWelcomeState,
            class_basename(new RegistrationState) => new RegistrationState,

            // Customer Welcome states
            class_basename(new CustomerWelcomeState) => new CustomerWelcomeState,
            class_basename(new MyAccountState) => new MyAccountState,

            class_basename(new MySusuAccountsState) => new MySusuAccountsState,
            class_basename(new MyLoanAccountsState) => new MyLoanAccountsState,
            class_basename(new MyInvestmentAccountsState) => new MyInvestmentAccountsState,
            class_basename(new MyInsuranceAccountsState) => new MyInsuranceAccountsState,
            class_basename(new MyPensionAccountsState) => new MyPensionAccountsState,

            class_basename(new LinkedWalletsState) => new LinkedWalletsState,
            class_basename(new LinkNewWalletState) => new LinkNewWalletState,
            class_basename(new LinkGhanaCardState) => new LinkGhanaCardState,
            class_basename(new ChangePinState) => new ChangePinState,

            class_basename(new LinkedWalletState) => new LinkedWalletState,

            // Customer / Guest shared states
            class_basename(new AboutSusuboxState) => new AboutSusuboxState,
            class_basename(new TermsAndConditionsState) => new TermsAndConditionsState,



            // Susu states
            class_basename(new SusuState) => new SusuState,
            class_basename(new StartSusuState) => new StartSusuState,

            class_basename(new AboutSusuState) => new AboutSusuState,
            class_basename(new AboutSusuSchemesState) => new AboutSusuSchemesState,
            class_basename(new AboutSusuCollectionsState) => new AboutSusuCollectionsState,
            class_basename(new AboutSusuWithdrawalsState) => new AboutSusuWithdrawalsState,
            class_basename(new AboutSusuFeesChargesState) => new AboutSusuFeesChargesState,

            class_basename(new SusuTermsState) => new SusuTermsState,

            class_basename(new SusuBalanceState) => new SusuBalanceState,
            class_basename(new SusuMiniStatementState) => new SusuMiniStatementState,

            // PersonalSusu account states
            class_basename(new PersonalSusuAccountState) => new PersonalSusuAccountState,
            class_basename(new PersonalSusuCreateState) => new PersonalSusuCreateState,
            class_basename(new PersonalSusuPaymentState) => new PersonalSusuPaymentState,
            class_basename(new PersonalSusuSettlementState) => new PersonalSusuSettlementState,
            class_basename(new PersonalSusuSettlementPendingState) => new PersonalSusuSettlementPendingState,
            class_basename(new PersonalSusuSettlementAllPendingState) => new PersonalSusuSettlementAllPendingState,
            class_basename(new PersonalSusuSettlementZeroOutState) => new PersonalSusuSettlementZeroOutState,
            class_basename(new PersonalSusuCollectionState) => new PersonalSusuCollectionState,
            class_basename(new PersonalSusuCollectionSummaryState) => new PersonalSusuCollectionSummaryState,
            class_basename(new PersonalSusuCollectionPauseState) => new PersonalSusuCollectionPauseState,
            class_basename(new PersonalSusuAccountLockState) => new PersonalSusuAccountLockState,

            // BizSusu account states
            class_basename(new BizSusuAccountState) => new BizSusuAccountState,
            class_basename(new BizSusuCreateState) => new BizSusuCreateState,
            class_basename(new BizSusuPaymentState) => new BizSusuPaymentState,
            class_basename(new BizSusuPaymentFrequencyState) => new BizSusuPaymentFrequencyState,
            class_basename(new BizSusuPaymentAmountState) => new BizSusuPaymentAmountState,
            class_basename(new BizSusuWithdrawalState) => new BizSusuWithdrawalState,
            class_basename(new BizSusuWithdrawalPartialState) => new BizSusuWithdrawalPartialState,
            class_basename(new BizSusuWithdrawalFullState) => new BizSusuWithdrawalFullState,
            class_basename(new BizSusuCollectionState) => new BizSusuCollectionState,
            class_basename(new BizSusuCollectionSummaryState) => new BizSusuCollectionSummaryState,
            class_basename(new BizSusuCollectionPauseState) => new BizSusuCollectionPauseState,
            class_basename(new BizSusuAccountLockState) => new BizSusuAccountLockState,

            // GoalGetterSusu account states
            class_basename(new GoalGetterSusuAccountState) => new GoalGetterSusuAccountState,
            class_basename(new GoalGetterSusuCreateState) => new GoalGetterSusuCreateState,
            class_basename(new GoalGetterSusuPaymentState) => new GoalGetterSusuPaymentState,
            class_basename(new GoalGetterSusuPaymentFrequencyState) => new GoalGetterSusuPaymentFrequencyState,
            class_basename(new GoalGetterSusuPaymentAmountState) => new GoalGetterSusuPaymentAmountState,
            class_basename(new GoalGetterSusuCollectionState) => new GoalGetterSusuCollectionState,
            class_basename(new GoalGetterSusuCollectionSummaryState) => new GoalGetterSusuCollectionSummaryState,
            class_basename(new GoalGetterSusuGoalSummaryState) => new GoalGetterSusuGoalSummaryState,
            class_basename(new GoalGetterSusuWithdrawalState) => new GoalGetterSusuWithdrawalState,
            class_basename(new GoalGetterSusuWithdrawalPartialState) => new GoalGetterSusuWithdrawalPartialState,
            class_basename(new GoalGetterSusuWithdrawalFullState) => new GoalGetterSusuWithdrawalFullState,

            // GoalGetterSusu account states
            class_basename(new FlexySusuAccountState) => new FlexySusuAccountState,
            class_basename(new FlexySusuCreateState) => new FlexySusuCreateState,
            class_basename(new FlexySusuPaymentState) => new FlexySusuPaymentState,
            class_basename(new FlexySusuWithdrawalState) => new FlexySusuWithdrawalState,
            class_basename(new FlexySusuWithdrawalPartialState) => new FlexySusuWithdrawalPartialState,
            class_basename(new FlexySusuWithdrawalFullState) => new FlexySusuWithdrawalFullState,
            class_basename(new FlexySusuCollectionState) => new FlexySusuCollectionState,
            class_basename(new FlexySusuCollectionPauseState) => new FlexySusuCollectionPauseState,
            class_basename(new FlexySusuAccountLockState) => new FlexySusuAccountLockState,



            // Loan states
            class_basename(new LoanState) => new LoanState,
            class_basename(new GetLoanState) => new GetLoanState,

            class_basename(new AboutLoansState) => new AboutLoansState,
            class_basename(new AboutLoanSchemesState) => new AboutLoanSchemesState,
            class_basename(new AboutLoanQualificationState) => new AboutLoanQualificationState,
            class_basename(new AboutLoanApplicationState) => new AboutLoanApplicationState,
            class_basename(new AboutLoanCollateralState) => new AboutLoanCollateralState,
            class_basename(new AboutLoanDisbursementState) => new AboutLoanDisbursementState,
            class_basename(new AboutLoanRepaymentState) => new AboutLoanRepaymentState,
            class_basename(new AboutLoanInterestState) => new AboutLoanInterestState,

            class_basename(new LoanTermsState) => new LoanTermsState,

            // PersonalSusuLoan account states
            class_basename(new PersonalSusuLoanAccountState) => new PersonalSusuLoanAccountState,

            // BizSusuLoanState account states
            class_basename(new BizSusuLoanAccountState) => new BizSusuLoanAccountState,

            // SwiftLoanState account states
            class_basename(new SwiftLoanAccountState) => new SwiftLoanAccountState,

            // LoanAccountState shared (Options)
            class_basename(new LoanBalanceState) => new LoanBalanceState,



            // Investment states
            class_basename(new InvestmentState) => new InvestmentState,
            class_basename(new StartInvestmentState) => new StartInvestmentState,

            class_basename(new AboutInvestmentState) => new AboutInvestmentState,
            class_basename(new InvestmentSchemesState) => new InvestmentSchemesState,
            class_basename(new InvestmentContributionsState) => new InvestmentContributionsState,
            class_basename(new InvestmentReturnsState) => new InvestmentReturnsState,
            class_basename(new InvestmentWithdrawalsState) => new InvestmentWithdrawalsState,
            class_basename(new InvestmentCommissionsState) => new InvestmentCommissionsState,

            class_basename(new InvestmentTermsState) => new InvestmentTermsState,



            // Insurance states
            class_basename(new InsuranceState) => new InsuranceState,
            class_basename(new StartInsuranceState) => new StartInsuranceState,

            class_basename(new AboutInsuranceState) => new AboutInsuranceState,
            class_basename(new AboutInsuranceSchemesState) => new AboutInsuranceSchemesState,
            class_basename(new AboutInsuranceCoverageState) => new AboutInsuranceCoverageState,
            class_basename(new AboutInsurancePremiumsState) => new AboutInsurancePremiumsState,
            class_basename(new AboutInsuranceContributionsState) => new AboutInsuranceContributionsState,
            class_basename(new AboutInsuranceClaimsState) => new AboutInsuranceClaimsState,
            class_basename(new AboutInsurancePayoutsState) => new AboutInsurancePayoutsState,
            class_basename(new AboutInsuranceCommissionsState) => new AboutInsuranceCommissionsState,

            class_basename(new InsuranceTermsState) => new InsuranceTermsState,



            // Pension states
            class_basename(new PensionState) => new PensionState,
            class_basename(new StartPensionState) => new StartPensionState,

            class_basename(new AboutPensionState) => new AboutPensionState,
            class_basename(new AboutPensionSchemesState) => new AboutPensionSchemesState,
            class_basename(new AboutPensionBenefitsState) => new AboutPensionBenefitsState,
            class_basename(new AboutPensionGuaranteesState) => new AboutPensionGuaranteesState,
            class_basename(new AboutPensionContributionsState) => new AboutPensionContributionsState,
            class_basename(new AboutPensionPayoutsState) => new AboutPensionPayoutsState,
            class_basename(new AboutPensionCommissionsState) => new AboutPensionCommissionsState,

            class_basename(new PensionTermsState) => new PensionTermsState,
        ];
    }
}
