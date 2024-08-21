<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Withdrawal;

use App\Services\Susu\Requests\BizSusu\Withdrawal\SusuServiceBizSusuWithdrawalApprovalRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServiceBizSusuWithdrawalApprovalRequest HTTP request response
        $response = (new SusuServiceBizSusuWithdrawalApprovalRequest)->execute(
            customer: $customer,
            data: PinApprovalData::toArray($session_data->user_input),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'),
            withdrawal_resource: data_get(target: $user_inputs, key: 'withdrawal_data.resource_id'),
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the requestNotification and terminate the session
        return GeneralMenu::requestNotification(session: $session);
    }
}
