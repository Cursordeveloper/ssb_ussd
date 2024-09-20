<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Lock;

use App\Services\Susu\Requests\FlexySusu\Lock\SusuServiceFlexySusuAccountLockApprovalRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountLockApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServiceFlexySusuAccountLockApprovalRequest HTTP request and return the response
        $balance = (new SusuServiceFlexySusuAccountLockApprovalRequest)->execute(
            customer: $customer,
            data: PinApprovalData::toArray($service_data->user_input),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'),
            lock_resource: data_get(target: $user_inputs, key: 'account_lock_data.resource'),
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $balance, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the requestNotification and terminate the session
        return GeneralMenu::requestNotification(session: $session);
    }
}
