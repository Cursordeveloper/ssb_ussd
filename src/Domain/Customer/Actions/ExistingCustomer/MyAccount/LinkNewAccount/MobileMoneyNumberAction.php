<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\CustomerService;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MobileMoneyNumberAction
{
    public static function execute(Session $session, $session_data, array $steps_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['mobileMoneyNumber' => $session_data->user_input]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Prepare request data
        $network_resources = ['mtn' => '3f6dd164-6191-42e0-9ad2-9ba709460835', 'airteltigo' => '68dd39c9-73c7-4fc6-af55-bfbb0c893f2a', 'vodafone' => '3f6dd164-6191-42e0-9ad2-9ba709460835'];
        $data = ['phone_number' => $session_data->user_input, 'network_resource' => $network_resources[$steps_data['selectNetwork']]];

        // Send request
        $response = (new CustomerService)->linkNewAccount(customer: $customer, data: $data);

        if (data_get(target: $response, key: 'status') === true) {
            // Return the enterPinMenu
            return LinkNewWalletMenu::enterPinMenu(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session->session_id);
    }
}
