<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Account;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Account\GoalGetterSusuAccountMenu;
use Domain\Susu\GoalGetterSusu\Menus\Collection\GoalGetterSusuCollectionMenu;
use Domain\Susu\GoalGetterSusu\Menus\Payment\GoalGetterSusuPaymentMenu;
use Domain\Susu\GoalGetterSusu\Menus\Withdrawal\GoalGetterSusuWithdrawalMenu;
use Domain\Susu\GoalGetterSusu\States\Collection\GoalGetterSusuCollectionState;
use Domain\Susu\GoalGetterSusu\States\Payment\GoalGetterSusuPaymentState;
use Domain\Susu\GoalGetterSusu\States\Withdrawal\GoalGetterSusuWithdrawalState;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuAccountState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['state' => new GoalGetterSusuPaymentState, 'menu' => new GoalGetterSusuPaymentMenu],
            '3' => ['state' => new GoalGetterSusuCollectionState, 'menu' => new GoalGetterSusuCollectionMenu],
            '4' => ['state' => new GoalGetterSusuWithdrawalState, 'menu' => new GoalGetterSusuWithdrawalMenu],
            '5' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '0' => ['state' => new MySusuAccountsState, 'menu' => new MySusuAccountsMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists($service_data->user_input, $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['state']), service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // Return the invalidMainMenu
        return GoalGetterSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
