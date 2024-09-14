<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use App\Services\Susu\Data\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementCancellationRequest;
use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementApprovalAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $session_data->user_input === '2' => self::settlementCancellation(session: $session),
            SusuValidationAction::pinLengthValid($session_data->user_input) === false => SusuValidationMenu::pinLengthMenu(session: $session),

            default => self::settlementApproval(session: $session, session_data: $session_data)
        };
    }

    public static function settlementApproval(Session $session, $session_data): JsonResponse
    {
        // Execute and return the customer data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuSettlementApprovalRequest and return the response
        $approval_response = (new SusuServicePersonalSusuSettlementApprovalRequest)->execute(
            customer: $customer,
            data: PinApprovalData::toArray($session_data->user_input),
            susu_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'susu_account.attributes.resource_id'),
            settlement_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'settlement_resource'),
        );

        // Process response and return menu
        return match (true) {
            data_get($approval_response, key: 'code') === 200 => GeneralMenu::paymentNotificationMenu(session: $session),
            data_get($approval_response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function settlementCancellation(Session $session): JsonResponse
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuSettlementCancellationRequest HTTP request
        $cancel_response = (new SusuServicePersonalSusuSettlementCancellationRequest)->execute(
            customer: $customer,
            data: SusuServicePersonalSusuSettlementCancellationData::toArray(),
            susu_resource: data_get(target: json_decode($session->user_inputs, associative: true), key: 'susu_account.attributes.resource_id'),
            settlement_resource: json_decode($session->user_inputs, associative: true)['settlement_resource']
        );

        // Process response and return menu
        return match (true) {
            data_get($cancel_response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $cancel_response, key: 'description')),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
