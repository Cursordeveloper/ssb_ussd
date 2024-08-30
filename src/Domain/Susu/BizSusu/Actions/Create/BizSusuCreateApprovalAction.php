<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use App\Services\Susu\Requests\BizSusu\BizSusuApprovalRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_inputs
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the createPersonalSusu HTTP request
        $susu_approved = (new BizSusuApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input), susu_resource: $user_inputs);

        // Return the createAccountNotification and terminate the session
        if (data_get($susu_approved, key: 'code') === 200) {
            return GeneralMenu::createAccountNotification(session: $session);
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
