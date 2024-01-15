<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\Requests\LinkNewAccountApprovalRequest;
use Domain\ExistingCustomer\Data\MyAccount\LinkedWallets\LinkNewAccountApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
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
        $response = (new LinkNewAccountApprovalRequest)->execute(customer: $customer, data: LinkNewAccountApprovalData::toArray(account_number: $user_inputs['mobile_money_number'], pin: $session_data->user_input));

        // Return requestNotification if request is successful
        if (data_get(target: $response, key: 'status') === true) {
            return GeneralMenu::requestNotification(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session->session_id);
    }
}
