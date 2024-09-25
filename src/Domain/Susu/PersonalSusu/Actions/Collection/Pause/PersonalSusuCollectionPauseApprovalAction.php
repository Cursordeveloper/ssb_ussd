<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Collection\Pause;

use App\Services\Susu\Data\PersonalSusu\Collection\Pause\SusuServicePersonalSusuCollectionPauseCancellationData;
use App\Services\Susu\Requests\PersonalSusu\Collection\Pause\SusuServicePersonalSusuCollectionPauseApprovalRequest;
use App\Services\Susu\Requests\PersonalSusu\Collection\Pause\SusuServicePersonalSusuCollectionPauseCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionPauseApprovalAction
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
        // Execute the SusuServicePersonalSusuPaymentApprovalRequest and return the response
        $response = (new SusuServicePersonalSusuCollectionPauseApprovalRequest)->execute(
            customer: $session->customer,
            data: PinApprovalData::toArray($service_data->user_input),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'),
            pause_resource: data_get(target: $session->userInputs(), key: 'collection_pause_data.resource_id'),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::requestNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function cancelExecution(Session $session): JsonResponse
    {
        // Execute the SusuServicePersonalSusuCollectionPauseCancellationRequest HTTP request
        $response = (new SusuServicePersonalSusuCollectionPauseCancellationRequest)->execute(
            customer: $session->customer,
            data: SusuServicePersonalSusuCollectionPauseCancellationData::toArray(),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'),
            pause_resource: data_get(target: $session->userInputs(), key: 'collection_pause_data.resource_id'),
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::infoNotification(session: $session, message: data_get(target: $response, key: 'description')),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }
}
