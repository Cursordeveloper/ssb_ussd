<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use App\Services\Susu\Data\FlexySusu\Create\FlexySusuCancellationData;
use App\Services\Susu\Requests\FlexySusu\Create\FlexySusuApprovalRequest;
use App\Services\Susu\Requests\FlexySusu\Create\FlexySusuCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => self::susuCancel(session: $session),

            default => self::susuApproval(session: $session, service_data: $service_data)
        };
    }

    public static function susuApproval(Session $session, $service_data): JsonResponse
    {
        // Execute the approvalRequest and return the response data
        $response = self::approvalRequest(session: $session, service_data: $service_data);

        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::createAccountNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function approvalRequest(Session $session, $service_data): array
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the FlexySusuApprovalRequest HTTP request
        return (new FlexySusuApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($service_data->user_input), susu_resource: $user_inputs);
    }

    public static function susuCancel(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the GoalGetterSusuCancellationRequest HTTP request
        (new FlexySusuCancellationRequest)->execute(customer: $customer, data: FlexySusuCancellationData::toArray(), susu_resource: $user_inputs);

        // Return the cancelAccountNotification and terminate the session
        return GeneralMenu::processCancelNotification(session: $session);
    }
}
