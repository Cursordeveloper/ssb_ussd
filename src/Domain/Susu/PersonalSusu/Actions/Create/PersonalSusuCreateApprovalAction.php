<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use App\Services\Susu\Data\PersonalSusu\Create\PersonalSusuCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Create\PersonalSusuApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Create\PersonalSusuCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateApprovalAction
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
            data_get($response, key: 'code') === 401 => GeneralMenu::invalidPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function approvalRequest(Session $session, $session_data): array
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the createPersonalSusu HTTP request
        return (new PersonalSusuApprovalRequest)->execute(customer: $customer, data: PinApprovalData::toArray($session_data->user_input), susu_resource: $user_inputs);
    }

    public static function susuCancel(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the PersonalSusuCancellationRequest HTTP request
        (new PersonalSusuCancellationRequest)->execute(customer: $customer, data: PersonalSusuCancellationData::toArray(), susu_resource: $user_inputs);

        // Return the cancelAccountNotification and terminate the session
        return GeneralMenu::cancelAccountNotification(session: $session);
    }
}
