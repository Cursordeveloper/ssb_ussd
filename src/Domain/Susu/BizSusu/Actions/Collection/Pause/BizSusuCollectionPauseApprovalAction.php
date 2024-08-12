<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Collection\Pause;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\BizSusu\Collection\Pause\SusuServiceBizSusuCollectionPauseApprovalRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCollectionPauseApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);
        $user_data = json_decode($session->user_data, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $balance = (new SusuServiceBizSusuCollectionPauseApprovalRequest)->execute(
            customer: $customer,
            data: PinApprovalData::toArray($session_data->user_input),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'),
            pause_resource: data_get(target: $user_data, key: 'collection_pause_data.resource'),
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $balance, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the requestNotification and terminate the session
        return GeneralMenu::requestNotification(session: $session);
    }
}
