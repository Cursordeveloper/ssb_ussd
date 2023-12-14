<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\LinkNewAccount;

use App\Menus\Shared\GeneralMenu;
use App\Services\Customer\CustomerService;
use Domain\Customer\Actions\Common\GetCustomerAction;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StepFourAction
{
    public static function execute(Session $session, $session_data, array $steps_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['step5' => 'pin_entered']);

        // Get the customer
        $customer = GetCustomerAction::execute(resource: $session->phone_number);

        // Prepare request data
        $data = ['phone_number' => $steps_data['step3'], 'pin' => $session_data->user_input];

        // Send request
        $response = (new CustomerService)->linkNewAccountApproval(customer: $customer, data: $data);

        if (data_get(target: $response, key: 'status') === true) {
            return GeneralMenu::infoNotification(
                message: 'Successful: You will receive confirmation shortly.',
                session: data_get(target: $session, key: 'session_id'),
            );
        }

        // Terminate the session
        return GeneralMenu::invalidInput(session: $session->session_id);
    }
}
