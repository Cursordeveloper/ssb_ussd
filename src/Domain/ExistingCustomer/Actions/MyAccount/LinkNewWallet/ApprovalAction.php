<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Services\Customer\Requests\LinkedAccount\LinkNewAccountApprovalRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ApprovalAction
{
    public static function execute(Session $session, $session_data, array $user_inputs): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Execute and send the LinkNewAccountApprovalRequest []
        $response = (new LinkNewAccountApprovalRequest)->execute(
            customer: $customer,
            linked_account: $user_inputs['linked_account_resource_id'],
            data: PinApprovalData::toArray(pin: $session_data->user_input),
        );

        // Return requestNotification if request is successful
        if (data_get(target: $response, key: 'code') === 200) {
            return GeneralMenu::requestNotification(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
