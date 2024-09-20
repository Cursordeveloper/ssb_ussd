<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\States\StartSusu;

use App\Common\Helpers;
use App\Common\LinkedWallets;
use App\Services\Susu\Requests\Customer\SusuServiceLinkAccountsRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Action\Session\SessionStateUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Create\BizSusuCreateMenu;
use Domain\Susu\BizSusu\States\Create\BizSusuCreateState;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Domain\Susu\FlexySusu\States\Create\FlexySusuCreateState;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Domain\Susu\GoalGetterSusu\States\Create\GoalGetterSusuCreateState;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Domain\Susu\PersonalSusu\States\Create\PersonalSusuCreateState;
use Domain\Susu\Shared\Actions\Common\GetSusuSchemesAction;
use Domain\Susu\Shared\Menus\StartSusu\StartSusuMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Domain\User\Customer\Menus\MyAccount\LinkedWallet\LinkNewWalletMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StartSusuState
{
    public static function execute(Session $session, $service_data): JsonResponse
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
        if (array_key_exists(key: $service_data->user_input, array: $stateMappings)) {
            // Get the customer option state
            $customer_state = $stateMappings[$service_data->user_input];

            // Update the customer session action
            SessionStateUpdateAction::execute(session: $session, state: class_basename($customer_state['class']), service_data: $service_data);

            // Execute the SessionInputUpdateAction
            GetSusuSchemesAction::execute(session: $session, service_data: $service_data);

            // Execute the state
            return $customer_state['menu']::mainMenu(session: $session);
        }

        // The customer input is invalid
        return StartSusuMenu::invalidMainMenu(session: $session);
    }
}
