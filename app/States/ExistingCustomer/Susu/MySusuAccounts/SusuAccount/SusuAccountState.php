<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance\SusuBalanceMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuCloseAccount\SusuCloseAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPauseAccount\SusuPauseAccountMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuPayment\SusuPaymentMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuWithdrawalMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountBalance\SusuAccountBalanceState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountClose\SusuAccountCloseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountPause\SusuAccountPauseState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountPayment\SusuAccountPaymentState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountWithdrawal\SusuAccountWithdrawalState;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new SusuAccountBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['class' => new SusuAccountPaymentState, 'menu' => new SusuPaymentMenu],
            '3' => ['class' => new SusuAccountWithdrawalState, 'menu' => new SusuWithdrawalMenu],
            '4' => ['class' => new SusuAccountPauseState, 'menu' => new SusuPauseAccountMenu],
            '5' => ['class' => new SusuAccountCloseState, 'menu' => new SusuCloseAccountMenu],
            '0' => ['class' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return SusuAccountMenu::invalidMainMenu(session: $session);
    }
}
