<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\StartSusu;

use App\Common\Helpers;
use App\Common\LinkedWallets;
use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\ExistingCustomer\Susu\StartSusu\StartSusuMenu;
use App\Services\Susu\Requests\Customer\SusuServiceLinkAccountsRequest;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\SusuSchemes\GetSusuSchemesAction;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\UpdateSessionStateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Susu\BizSusuCreateMenu;
use Domain\Susu\BizSusu\States\Susu\BizSusuCreateState;
use Domain\Susu\FlexySusu\Menus\Susu\FlexySusuCreateMenu;
use Domain\Susu\FlexySusu\States\Susu\FlexySusuCreateState;
use Domain\Susu\GoalGetterSusu\Menus\Susu\GoalGetterSusuCreateMenu;
use Domain\Susu\GoalGetterSusu\States\Susu\GoalGetterSusuCreateState;
use Domain\Susu\PersonalSusu\Menus\Susu\PersonalSusuCreateMenu;
use Domain\Susu\PersonalSusu\States\Susu\PersonalSusuCreateState;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the GetCustomerAction and return the [Customer] model
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Execute and store the SusuServiceLinkAccountsRequest
        $linked_wallets = (new SusuServiceLinkAccountsRequest)->execute(customer: $customer);

        // Return the (noLinkedAccountMenu) if customer has no linked account(s)
        if (empty(data_get(target: $linked_wallets, key: 'data'))) {
            return LinkNewWalletMenu::noLinkedAccountMenu(session: $session);
        }

        // Format the wallets and (updateUserData) with the wallets data
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['linked_wallets' => Helpers::arrayIndex(LinkedWallets::formatLinkedWalletsInArray($linked_wallets['data']))]);

        // Define a mapping between customer input and states
        $stateMappings = [
            '1' => ['class' => new PersonalSusuCreateState, 'menu' => new PersonalSusuCreateMenu],
            '2' => ['class' => new BizSusuCreateState, 'menu' => new BizSusuCreateMenu],
            '3' => ['class' => new GoalGetterSusuCreateState, 'menu' => new GoalGetterSusuCreateMenu],
            '4' => ['class' => new FlexySusuCreateState, 'menu' => new FlexySusuCreateMenu],
        ];

        // Check if the customer input is a valid option
        if (array_key_exists(key: $session_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$session_data->user_input];

            // Update the customer session action
            UpdateSessionStateAction::execute(session: $session, state: class_basename($customer_state['class']), session_data: $session_data);

            // Execute the SessionInputUpdateAction
            GetSusuSchemesAction::execute(session: $session, session_data: $session_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return StartSusuMenu::invalidMainMenu(session: $session);
    }
}
