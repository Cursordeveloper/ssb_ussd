<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\GoalGetterSusu\GoalGetterSusuApprovalRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_inputs
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the createPersonalSusu HTTP request
        $susu_approved = (new GoalGetterSusuApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input), susu_resource: $user_inputs);

        // Return the createAccountNotification and terminate the session
        if (data_get($susu_approved, key: 'code') === 200) {
            return GeneralMenu::createAccountNotification(session: $session);
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
