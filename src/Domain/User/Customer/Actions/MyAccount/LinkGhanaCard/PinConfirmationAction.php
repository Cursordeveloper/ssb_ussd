<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\LinkGhanaCard;

use App\Services\Customer\Requests\Kyc\LinkKycApprovalRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Domain\User\Customer\Data\MyAccount\LinkGhanaCard\LinkGhanaCardApprovalData;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PinConfirmationAction
{
    public static function execute(Session $session, $session_data, array $user_inputs): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['pin_confirmation' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Send request
        $response = (new LinkKycApprovalRequest)->execute(customer: $customer, kyc_resource: $user_inputs['kyc_resource_id'], data: LinkGhanaCardApprovalData::toArray(pin: $session_data->user_input));

        // Return requestNotification if request is successful
        if (data_get(target: $response, key: 'code') === 200) {
            return GeneralMenu::requestNotification(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
