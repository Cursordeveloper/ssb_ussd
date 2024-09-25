<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Payment;

use App\Services\Susu\Data\PersonalSusu\Payment\SusuServicePersonalSusuPaymentCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => self::cancellationExecution(session: $session),
            GeneralValidation::pinLengthValid($service_data->user_input) === false => GeneralMenu::pinLengthMenu(session: $session),

            default => self::approvalExecution(session: $session, service_data: $service_data)
        };
    }

    private static function approvalExecution(Session $session, $service_data): JsonResponse
    {
        // Execute the SusuServicePersonalSusuPaymentApprovalRequest and return the response
        $response = (new SusuServicePersonalSusuPaymentApprovalRequest)->execute(
            customer: $session->customer,
            data: PinApprovalData::toArray($service_data->user_input),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'),
            payment_resource: data_get(target: $session->userInputs(), key: 'payment_resource'),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::paymentNotificationMenu(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    private static function cancellationExecution(Session $session): JsonResponse
    {
        // Execute the SusuServicePersonalSusuPaymentCancellationRequest HTTP request
        $response = (new SusuServicePersonalSusuPaymentCancellationRequest)->execute(
            customer: $session->customer,
            data: SusuServicePersonalSusuPaymentCancellationData::toArray(),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'),
            payment_resource: data_get(target: $session->userInputs(), key: 'payment_resource'),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $response, key: 'description')),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
