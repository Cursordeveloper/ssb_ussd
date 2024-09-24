<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\SusuBalance;

use App\Services\Susu\Requests\Susu\SusuServiceSusuBalanceRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Balance\SusuBalanceMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Execute and return the response (menu)
        return match (true) {
            $service_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),
            GeneralValidation::pinLengthValid($service_data->user_input) === false => GeneralMenu::pinLengthMenu(session: $session),
            default => self::approvalExecution(session: $session, service_data: $service_data)
        };
    }

    public static function approvalExecution(Session $session, $service_data): JsonResponse
    {
        // Execute the approvalRequest and return the response data
        $response = (new SusuServiceSusuBalanceRequest)->execute(customer: $session->customer, susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'), data: PinApprovalData::toArray($service_data->user_input));

        return match (true) {
            data_get($response, key: 'code') === 200 => SusuBalanceMenu::susuBalanceMenu(session: $session, susu_data: data_get(target: $response, key: 'data')),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
