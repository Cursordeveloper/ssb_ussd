<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use App\Services\Susu\Data\PersonalSusu\Create\PersonalSusuCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Create\PersonalSusuApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Create\PersonalSusuCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => self::cancelExecution(session: $session),
            GeneralValidation::pinLengthValid($service_data->user_input) === false => GeneralMenu::pinLengthMenu(session: $session),

            default => self::approvalExecution(session: $session, service_data: $service_data)
        };
    }

    public static function approvalExecution(Session $session, $service_data): JsonResponse
    {
        // Execute the PersonalSusuApprovalRequest and return the response data
        $response = (new PersonalSusuApprovalRequest)->execute(customer: $session->customer, data: PinApprovalData::toArray($service_data->user_input), susu_resource: $session->userInputs()['susu_resource']);

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::createAccountNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function cancelExecution(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the session user_data
        $user_inputs = json_decode($session->user_inputs, associative: true)['susu_resource'];

        // Execute the PersonalSusuCancellationRequest HTTP request
        (new PersonalSusuCancellationRequest)->execute(customer: $customer, data: PersonalSusuCancellationData::toArray(), susu_resource: $user_inputs);

        // Return the processCancelNotification and terminate the session
        return GeneralMenu::processCancelNotification(session: $session);
    }
}
