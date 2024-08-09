<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Account;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseMenu;
use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuAccountMenu;
use App\States\ExistingCustomer\Susu\MySusuAccounts\MySusuAccountsState;
use App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountCloseState;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Menus\Susu\Balance\SusuAccountBalanceMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Shared\States\Susu\Balance\SusuAccountBalanceState;
use Domain\Susu\BizSusu\Menus\Pause\BizSusuCollectionPauseMenu;
use Domain\Susu\BizSusu\Menus\Payment\BizSusuPaymentMenu;
use Domain\Susu\BizSusu\Menus\Withdrawal\BizSusuWithdrawalMenu;
use Domain\Susu\BizSusu\States\Pause\BizSusuCollectionPauseState;
use Domain\Susu\BizSusu\States\Payment\BizSusuPaymentState;
use Domain\Susu\BizSusu\States\Withdrawal\BizSusuWithdrawalState;
use Domain\Susu\Shared\Menus\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\SusuMiniStatementState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuAccountBalanceState, 'menu' => new SusuAccountBalanceMenu],
            '2' => ['state' => new BizSusuPaymentState, 'menu' => new BizSusuPaymentMenu],
            '3' => ['state' => new BizSusuWithdrawalState, 'menu' => new BizSusuWithdrawalMenu],
            '4' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '5' => ['state' => new BizSusuCollectionPauseState, 'menu' => new BizSusuCollectionPauseMenu],
            
            '6' => ['state' => new SusuAccountCloseState, 'menu' => new SusuAccountCloseMenu],

            '0' => ['state' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($session_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['state']), session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return SusuAccountMenu::invalidMainMenu(session: $session);
    }
}
