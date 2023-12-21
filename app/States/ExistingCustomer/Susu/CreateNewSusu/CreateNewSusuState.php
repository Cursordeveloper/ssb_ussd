<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\CreateNewSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use App\Services\Customer\CustomerService;
use App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuState;
use App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuState;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\SusuScheme\SusuProductAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Action\SessionUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the GetCustomerAction
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Get the linked accounts
        $linked_wallets = (new CustomerService)->linkedAccount(customer: $customer);

        // Check if the customer has linked account(s)
        if (empty(data_get(target: $linked_wallets, key: 'data'))) {
            // Update the customer session action
            SessionUpdateAction::execute(session: $session, state: 'LinkNewWalletState', session_data: $session);

            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::execute(session: $session, user_input: ['noWallet' => true]);

            // Return the linkedAccountMenu
            return LinkNewWalletMenu::linkedAccountMenu(session: $session);
        }

        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Check if the beginProcess is set
        if (! array_key_exists(key: 'beginProcess', array: $process_flow)) {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::execute(session: $session, user_input: ['beginProcess' => true, 'category' => 'susu']);

            // Return the CreateNewSusuMenu
            return CreateNewSusuMenu::mainMenu(session: $session);
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
            SusuProductAction::execute(session: $session, session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return CreateNewSusuMenu::invalidMainMenu(session: $session);
    }
}
