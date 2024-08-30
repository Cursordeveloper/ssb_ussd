<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Account;

use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Account\FlexySusuAccountMenu;
use Domain\Susu\FlexySusu\Menus\Collection\FlexySusuCollectionMenu;
use Domain\Susu\FlexySusu\Menus\Lock\FlexySusuAccountLockMenu;
use Domain\Susu\FlexySusu\Menus\Payment\FlexySusuPaymentMenu;
use Domain\Susu\FlexySusu\Menus\Withdrawal\FlexySusuWithdrawalMenu;
use Domain\Susu\FlexySusu\States\Collection\FlexySusuCollectionState;
use Domain\Susu\FlexySusu\States\Lock\FlexySusuAccountLockState;
use Domain\Susu\FlexySusu\States\Payment\FlexySusuPaymentState;
use Domain\Susu\FlexySusu\States\Withdrawal\FlexySusuWithdrawalState;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['state' => new FlexySusuPaymentState, 'menu' => new FlexySusuPaymentMenu],
            '3' => ['state' => new FlexySusuWithdrawalState, 'menu' => new FlexySusuWithdrawalMenu],
            '4' => ['state' => new FlexySusuCollectionState, 'menu' => new FlexySusuCollectionMenu],
            '5' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '6' => ['state' => new FlexySusuAccountLockState, 'menu' => new FlexySusuAccountLockMenu],
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
        return FlexySusuAccountMenu::invalidMainMenu(session: $session);
    }
}
