<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\Requests\LinkedAccount\LinkNewAccountRequest;
use Domain\ExistingCustomer\Data\MyAccount\LinkNewWallet\LinkNewAccountData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MobileNumberAction
{
    public static function execute(Session $session, $session_data, array $steps_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['mobile_number' => $session_data->user_input]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Send request
        $response = (new LinkNewAccountRequest)->execute(
            customer: $customer,
            data: LinkNewAccountData::toArray(phone_number: $session_data->user_input, resource_id: $steps_data['scheme_resource_id']),
        );

        // Return the enterPinMenu if status is true
        if (data_get(target: $response, key: 'code') === 200) {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['linked_account_resource_id' => data_get(target: $response, key: 'data.attributes.resource_id')]);

            return LinkNewWalletMenu::enterPinMenu(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
