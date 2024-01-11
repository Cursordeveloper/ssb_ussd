<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\CheckSusuBalance\CheckSusuBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\ManualSusuPayment\ManualSusuPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuWithdrawalState;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return to the SusuState if user input is (0)
        if ($session_data->user_input === '0') {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'MySusuAccountsState', session_data: $session_data);

            // Execute the resetUserInputs
            SessionInputUpdateAction::resetUserInputs(session: $session);

            // Return to the SusuState
            return MySusuAccountsState::execute(session: $session, session_data: $session_data);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new CheckSusuBalanceState,
            '2' => new ManualSusuPaymentState,
            '3' => new SusuWithdrawalState,
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state), session_data: $session_data);

            // Execute the state
            return $customer_state::execute(session: $session, session_data: $session_data);
        }

        // Return the invalidMainMenu
        return SusuAccountMenu::invalidMainMenu(session: $session, session_data: $session_data);
    }
}
