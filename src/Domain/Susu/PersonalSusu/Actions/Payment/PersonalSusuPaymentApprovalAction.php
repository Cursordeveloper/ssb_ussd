<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Payment;

use App\Services\Susu\Data\PersonalSusu\Payment\SusuServicePersonalSusuPaymentCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentCancellationRequest;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $session_data->user_input === '2' => self::paymentCancellation(session: $session),

            default => self::paymentApproval(session: $session, session_data: $session_data)
        };
    }

    public static function paymentApproval(Session $session, $session_data): JsonResponse
    {
        // Execute and return the customer data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuPaymentApprovalRequest and return the response
        $approval_response = (new SusuServicePersonalSusuPaymentApprovalRequest)->execute(
            customer: $customer,
            data: PinApprovalData::toArray($session_data->user_input),
            susu_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'susu_account.attributes.resource_id'),
            payment_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'payment_resource'),
        );

        // Process response and return menu
        return match (true) {
            data_get($approval_response, key: 'code') === 200 => GeneralMenu::paymentNotificationMenu(session: $session),
            data_get($approval_response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function paymentCancellation(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuPaymentCancellationRequest HTTP request
        $cancel_response = (new SusuServicePersonalSusuPaymentCancellationRequest)->execute(
            customer: $customer,
            data: SusuServicePersonalSusuPaymentCancellationData::toArray(),
            susu_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'susu_account.attributes.resource_id'),
            payment_resource: json_decode($session->user_inputs, associative: true)['payment_resource']
        );

        // Process response and return menu
        return match (true) {
            data_get($cancel_response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $cancel_response, key: 'description')),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
