<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkKyc;

use App\Menus\ExistingCustomer\MyAccount\LinkKyc\LinkKycMenu;
use App\Services\Customer\Requests\Kyc\LinkKycRequest;
use Domain\ExistingCustomer\Data\MyAccount\LinkKyc\LinkKycData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class IDNumberAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['id_number' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Send request
        $response = (new LinkKycRequest)->execute(customer: $customer, data: LinkKycData::toArray(id_number: $session_data->user_input));

        // Return the enterPinMenu if status is true
        if (data_get(target: $response, key: 'code') === 200) {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['kyc_resource_id' => data_get(target: $response, key: 'data.attributes.resource_id')]);

            return LinkKycMenu::enterPinMenu(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
