<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Account;

use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Account\PersonalSusuAccountMenu;
use Domain\Susu\PersonalSusu\Menus\Collection\PersonalSusuCollectionMenu;
use Domain\Susu\PersonalSusu\Menus\Lock\PersonalSusuAccountLockMenu;
use Domain\Susu\PersonalSusu\Menus\Payment\PersonalSusuPaymentMenu;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementMenu;
use Domain\Susu\PersonalSusu\States\Collection\PersonalSusuCollectionState;
use Domain\Susu\PersonalSusu\States\Lock\PersonalSusuAccountLockState;
use Domain\Susu\PersonalSusu\States\Payment\PersonalSusuPaymentState;
use Domain\Susu\PersonalSusu\States\Settlement\PersonalSusuSettlementState;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\Susu\Shared\States\Balance\SusuBalanceState;
use Domain\Susu\Shared\States\Statement\SusuMiniStatementState;
use Domain\User\Customer\Menus\MySusuAccounts\MySusuAccountsMenu;
use Domain\User\Customer\States\MySusuAccounts\MySusuAccountsState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['state' => new SusuBalanceState, 'menu' => new SusuBalanceMenu],
            '2' => ['state' => new PersonalSusuPaymentState, 'menu' => new PersonalSusuPaymentMenu],
            '3' => ['state' => new PersonalSusuSettlementState, 'menu' => new PersonalSusuSettlementMenu],
            '4' => ['state' => new PersonalSusuCollectionState, 'menu' => new PersonalSusuCollectionMenu],
            '5' => ['state' => new SusuMiniStatementState, 'menu' => new SusuMiniStatementMenu],
            '6' => ['state' => new PersonalSusuAccountLockState, 'menu' => new PersonalSusuAccountLockMenu],
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
        return PersonalSusuAccountMenu::invalidMainMenu(session: $session);
    }
}
