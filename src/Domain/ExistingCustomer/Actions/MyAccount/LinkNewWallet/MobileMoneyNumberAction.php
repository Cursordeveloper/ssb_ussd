<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\Requests\LinkNewAccountRequest;
use Domain\ExistingCustomer\Data\MyAccount\LinkedWallets\LinkNewAccountData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MobileMoneyNumberAction
{
    public static function execute(Session $session, $session_data, array $steps_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['mobile_money_number' => $session_data->user_input]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Prepare request data
        $network_resources = ['mtn' => '3f6dd164-6191-42e0-9ad2-9ba709460835', 'airteltigo' => '68dd39c9-73c7-4fc6-af55-bfbb0c893f2a', 'vodafone' => '3f6dd164-6191-42e0-9ad2-9ba709460835'];

        // Send request
        $response = (new LinkNewAccountRequest)->execute(customer: $customer, data: LinkNewAccountData::toArray($session_data->user_input, $network_resources[$steps_data['select_network']]));

        // Return the enterPinMenu if status is true
        if (data_get(target: $response, key: 'status') === true) {
            return LinkNewWalletMenu::enterPinMenu(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session->session_id);
    }
}
