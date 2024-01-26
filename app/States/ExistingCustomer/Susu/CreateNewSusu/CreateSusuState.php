<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\CreateSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use App\Services\Customer\Requests\LinkAccountsRequest;
use App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuState;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\SusuSchemes\GetSusuSchemesAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new LinkAccountsRequest)->execute(customer: $customer);

        // Terminate the sessions if customer has no linked account(s)
        if (empty(data_get(target: $linked_wallets, key: 'data'))) {
            return LinkNewWalletMenu::noLinkedAccountMenu(session: $session);
        }

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new CreatePersonalSusuState, 'menu' => new CreatePersonalSusuMenu],
            '2' => ['class' => new CreateBizSusuState, 'menu' => new CreateBizSusuMenu],
            '3' => ['class' => new CreateGoalGetterSusuState, 'menu' => new CreateGoalGetterSusuMenu],
            '4' => ['class' => new CreateFlexySusuState, 'menu' => new CreateFlexySusuMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the SessionInputUpdateAction
            GetSusuSchemesAction::execute(session: $session, session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return CreateSusuMenu::invalidMainMenu(session: $session);
    }
}
