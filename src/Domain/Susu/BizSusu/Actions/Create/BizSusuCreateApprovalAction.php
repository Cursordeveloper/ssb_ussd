<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use App\Services\Susu\Data\BizSusu\Create\BizSusuCancellationData;
use App\Services\Susu\Requests\BizSusu\Create\BizSusuApprovalRequest;
use App\Services\Susu\Requests\BizSusu\Create\BizSusuCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $session_data->user_input === '2' => self::susuCancel(session: $session),

            default => self::susuApproval(session: $session, session_data: $session_data)
        };
    }

    public static function susuApproval(Session $session, $session_data): JsonResponse
    {
        // Execute the approvalRequest and return the response data
        $response = self::approvalRequest(session: $session, session_data: $session_data);

        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::createAccountNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function approvalRequest(Session $session, $session_data): array
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the BizSusuApprovalRequest HTTP request
        return (new BizSusuApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input), susu_resource: $user_inputs);
    }

    public static function susuCancel(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the BizSusuCancellationRequest HTTP request
        (new BizSusuCancellationRequest)->execute(customer: $customer, data: BizSusuCancellationData::toArray(), susu_resource: $user_inputs);

        // Return the cancelAccountNotification and terminate the session
        return GeneralMenu::processCancelNotification(session: $session);
    }
}
