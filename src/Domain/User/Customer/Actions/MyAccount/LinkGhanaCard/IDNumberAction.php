<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkGhanaCard;

use App\Services\Customer\Requests\Kyc\LinkKycRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Domain\User\Customer\Data\MyAccount\LinkGhanaCard\LinkGhanaCardData;
use Domain\User\Customer\Menus\MyAccount\LinkGhanaCard\LinkGhCardMenu;
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
        $response = (new LinkKycRequest)->execute(customer: $customer, data: LinkGhanaCardData::toArray(id_number: $session_data->user_input));

        // Return the enterPinMenu if status is true
        if (data_get(target: $response, key: 'code') === 200) {
            // Execute the SessionInputUpdateAction
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['kyc_resource_id' => data_get(target: $response, key: 'data.attributes.resource_id')]);

            return LinkGhCardMenu::enterPinMenu(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
