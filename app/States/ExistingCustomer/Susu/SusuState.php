<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu;

use App\Menus\ExistingCustomer\Susu\SusuMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Susu\AboutSusu\AboutSusuState;
use App\States\ExistingCustomer\Susu\CheckBalance\CheckSusuBalanceState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\CreateSusuState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\Settlement\SettlementState;
use App\States\ExistingCustomer\Susu\SusuPayment\ManualSusuPaymentState;
use App\States\ExistingCustomer\Susu\SusuTerms\SusuTermsState;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new MySusuAccountsState,
            '2' => new CreateSusuState,
            '3' => new AboutSusuState,
            '5' => new SusuTermsState,
            '0' => new ExistingCustomerState,
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

        // Return the SusuMenu(invalidMainMenu)
        return SusuMenu::invalidMainMenu(session: $session);
    }
}
