<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Payment;

use App\Services\Susu\Data\FlexySusu\Payment\SusuServiceFlexySusuPaymentCancellationData;
use App\Services\Susu\Requests\FlexySusu\Payment\SusuServiceFlexySusuPaymentApprovalRequest;
use App\Services\Susu\Requests\FlexySusu\Payment\SusuServiceFlexySusuPaymentCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuPaymentApprovalAction
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
        // Execute the SusuServiceFlexySusuPaymentApprovalRequest and return the response
        $response = (new SusuServiceFlexySusuPaymentApprovalRequest)->execute(
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
        // Execute the SusuServiceFlexySusuPaymentCancellationRequest HTTP request
        $response = (new SusuServiceFlexySusuPaymentCancellationRequest)->execute(
            customer: $session->customer,
            data: SusuServiceFlexySusuPaymentCancellationData::toArray(),
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
