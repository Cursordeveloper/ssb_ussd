<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\SusuBalance;

use App\Services\Susu\Requests\Susu\SusuServiceSusuBalanceRequest;
use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $session_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),
            SusuValidationAction::pinLengthValid($session_data->user_input) === false => SusuValidationMenu::pinLengthMenu(session: $session),

            default => self::processApproval(session: $session, session_data: $session_data)
        };
    }

    public static function processApproval(Session $session, $session_data): JsonResponse
    {
        // Execute the approvalRequest and return the response data
        $response = self::approvalRequest(session: $session, session_data: $session_data);

        return match (true) {
            data_get($response, key: 'code') === 200 => SusuBalanceMenu::susuBalanceMenu(session: $session, susu_data: data_get(target: $response, key: 'data')),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function approvalRequest(Session $session, $session_data): array
    {
        // Execute the GetCustomerAction and return the data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Get the process flow array from the customer session (user inputs)
        $susu_account = json_decode($session->user_inputs, associative: true);

        // Execute the createPersonalSusu HTTP request
        return (new SusuServiceSusuBalanceRequest)->execute(customer: $customer, susu_resource: data_get(target: $susu_account, key: 'susu_account.attributes.resource_id'), data: PinApprovalData::toArray($session_data->user_input));
    }
}
