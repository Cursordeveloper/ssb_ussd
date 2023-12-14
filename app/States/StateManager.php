<?php

declare(strict_types=1);

namespace App\States;

use App\Menus\Shared\GeneralMenu;
use App\States\Account\ChangePinState;
use App\States\Account\LinkedWalletsState;
use App\States\Account\LinkNewWalletState;
use App\States\Account\MyAccountState;
use App\States\Customer\ExistingCustomerState;
use App\States\Customer\NewCustomerState;
use App\States\Insurance\InsuranceState;
use App\States\Investments\InvestmentsState;
use App\States\Loans\LoansState;
use App\States\Registration\RegistrationState;
use App\States\Susu\CreateNewSusu\CreateNewSusuState;
use App\States\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\Susu\SusuSavingsState;
use App\States\TermsAndConditions\TermsAndConditionsState;
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
            'NewCustomerState' => new NewCustomerState,
            'RegistrationState' => new RegistrationState,
            'ExistingCustomerState' => new ExistingCustomerState,
            'TermsAndConditionsState' => new TermsAndConditionsState,

            'SusuSavingsState' => new SusuSavingsState,
            'LoansState' => new LoansState,
            'InvestmentsState' => new InvestmentsState,
            'InsuranceState' => new InsuranceState,
            'MyAccountState' => new MyAccountState,

            'LinkedWalletsState' => new LinkedWalletsState,
            'LinkNewWalletState' => new LinkNewWalletState,
            'ChangePinState' => new ChangePinState,

            'MySusuAccountsState' => new MySusuAccountsState,
            'CreateNewSusuState' => new CreateNewSusuState,
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
