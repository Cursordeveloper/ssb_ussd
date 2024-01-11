<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\CustomerService;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PinConfirmationAction
{
    public static function execute(Session $session, $session_data, array $steps_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['pinConfirmation' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Prepare request data
        $data = ['phone_number' => $steps_data['mobileMoneyNumber'], 'pin' => $session_data->user_input];

        // Send request
        $response = (new CustomerService)->linkNewAccountApproval(customer: $customer, data: $data);

        if (data_get(target: $response, key: 'status') === true) {
            return GeneralMenu::requestNotification(session: $session);
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session->session_id);
    }
}
