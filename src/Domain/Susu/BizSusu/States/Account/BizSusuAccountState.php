<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Account;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Account\BizSusuAccountMenu;
use Domain\Susu\BizSusu\Menus\Collection\BizSusuCollectionMenu;
use Domain\Susu\BizSusu\Menus\Lock\BizSusuAccountLockMenu;
use Domain\Susu\BizSusu\Menus\Payment\BizSusuPaymentMenu;
use Domain\Susu\BizSusu\Menus\Withdrawal\BizSusuWithdrawalMenu;
use Domain\Susu\BizSusu\States\Collection\BizSusuCollectionState;
use Domain\Susu\BizSusu\States\Lock\BizSusuAccountLockState;
use Domain\Susu\BizSusu\States\Payment\BizSusuPaymentState;
use Domain\Susu\BizSusu\States\Withdrawal\BizSusuWithdrawalState;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['state' => new BizSusuPaymentState, 'menu' => new BizSusuPaymentMenu],
            '3' => ['state' => new BizSusuWithdrawalState, 'menu' => new BizSusuWithdrawalMenu],
            '4' => ['state' => new BizSusuCollectionState, 'menu' => new BizSusuCollectionMenu],
            '5' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '6' => ['state' => new BizSusuAccountLockState, 'menu' => new BizSusuAccountLockMenu],
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
        return BizSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
