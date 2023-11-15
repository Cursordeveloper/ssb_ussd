<?php

declare(strict_types=1);

namespace App\States;

use App\Menus\Shared\GeneralMenu;
use App\States\Account\MyAccountState;
use App\States\Customer\ExistingCustomerState;
use App\States\Customer\NewCustomerState;
use App\States\Insurance\InsuranceState;
use App\States\Investments\InvestmentsState;
use App\States\Loans\LoansState;
use App\States\Registration\RegistrationState;
use App\States\Susu\SusuSavingsState;
use App\States\TermsAndConditions\TermsAndConditionsState;
use App\States\Welcome\WelcomeState;
use Domain\Shared\Action\SessionCreateAction;
use Domain\Shared\Action\SessionGetAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StateManager
{
    public static function execute(
        Request $request,
    ): JsonResponse {
        // Check if the type is "initiation"
        if (strtolower(data_get(target: $request, key: 'Type')) === 'initiation') {
            // Create session
            $session = SessionCreateAction::execute(request: $request, state: 'WelcomeState');

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
        ];

        // Get the session
        $session = SessionGetAction::execute(session_id: data_get(target: $request, key: 'SessionId'));
        $customer_session = data_get(target: $session, key: 'state');

        if (array_key_exists($customer_session, $states)) {
            $customer_state = $states[$customer_session];

            // Return the state menu
            return $customer_state::execute($session, $request);
        }

        // Return a system failure message.
        return GeneralMenu::invalidInput(session: $session);
    }
}
