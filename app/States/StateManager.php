<?php

declare(strict_types=1);

namespace App\States;

use App\Menus\Shared\GeneralMenu;
use App\States\ExistingCustomer\Account\ChangePin\ChangePinState;
use App\States\ExistingCustomer\Account\LinkedWallets\LinkedWalletsState;
use App\States\ExistingCustomer\Account\LinkNewWallet\LinkNewWalletState;
use App\States\ExistingCustomer\Account\MyAccountState;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Insurance\InsuranceState;
use App\States\ExistingCustomer\Investments\InvestmentsState;
use App\States\ExistingCustomer\Loans\LoansState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\CreateNewSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\Settlement\SettlementState;
use App\States\ExistingCustomer\Susu\SusuSavingsState;
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

        $states = [
            // New customer states
            'NewCustomerState' => new NewCustomerState,
            'RegistrationState' => new RegistrationState,
            'TermsAndConditionsState' => new TermsAndConditionsState,

            // Existing customer states
            'ExistingCustomerState' => new ExistingCustomerState,
            'SusuSavingsState' => new SusuSavingsState,
            'LoansState' => new LoansState,
            'InvestmentsState' => new InvestmentsState,
            'InsuranceState' => new InsuranceState,
            'MyAccountState' => new MyAccountState,

            // MyAccountState options
            'LinkedWalletsState' => new LinkedWalletsState,
            'LinkNewWalletState' => new LinkNewWalletState,
            'ChangePinState' => new ChangePinState,

            // SusuSavingsState options
            'MySusuAccountsState' => new MySusuAccountsState,
            'CreateNewSusuState' => new CreateNewSusuState,
            'SettlementState' => new SettlementState,

            // CreateNewSusuState options
            'CreatePersonalSusuState' => new CreatePersonalSusuState,
            'CreateBizSusuState' => new CreateBizSusuState,
            'CreateGoalGetterSusuState' => new CreateGoalGetterSusuState,
            'CreateFlexySusuState' => new CreateFlexySusuState,
        ];

        // Get the session
        $session = SessionGetAction::execute(session_id: $state_data->session_id);
        $customer_session = data_get(target: $session, key: 'state');

        if (array_key_exists($customer_session, $states)) {
            $customer_state = $states[$customer_session];

            // Return the state menu
            return $customer_state::execute($session, $state_data);
        }

        // Return a system failure message.
        return GeneralMenu::invalidInput(session: $session);
    }
}
