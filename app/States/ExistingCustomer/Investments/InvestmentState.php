<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Investments;

use App\Menus\ExistingCustomer\Investment\InvestmentMenu;
use App\States\ExistingCustomer\ExistingCustomerState;
use App\States\ExistingCustomer\Investments\AboutInvestment\AboutInvestmentState;
use App\States\ExistingCustomer\Investments\Accounts\InvestmentAccountsState;
use App\States\ExistingCustomer\Investments\CreateInvestment\CreateInvestmentState;
use App\States\ExistingCustomer\Investments\InvestmentBalance\InvestmentBalanceState;
use App\States\ExistingCustomer\Investments\InvestmentTerms\InvestmentTermsState;
use App\States\ExistingCustomer\Investments\InvestmentWithdrawal\InvestmentWithdrawalState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class InvestmentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => new InvestmentAccountsState,
            '2' => new CreateInvestmentState,
            '3' => new InvestmentBalanceState,
            '4' => new AboutInvestmentState,
            '5' => new InvestmentTermsState,
            '6' => new InvestmentWithdrawalState,
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

        // Return the InvestmentMenu(invalidMainMenu)
        return InvestmentMenu::invalidMainMenu(session: $session);
    }
}
