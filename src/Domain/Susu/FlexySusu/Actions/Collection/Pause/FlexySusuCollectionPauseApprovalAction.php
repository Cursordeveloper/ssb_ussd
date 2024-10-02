<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Collection\Pause;

use App\Services\Susu\Data\FlexySusu\Collection\Pause\SusuServiceFlexySusuCollectionPauseCancellationData;
use App\Services\Susu\Requests\FlexySusu\Collection\Pause\SusuServiceFlexySusuCollectionPauseApprovalRequest;
use App\Services\Susu\Requests\FlexySusu\Collection\Pause\SusuServiceFlexySusuCollectionPauseCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCollectionPauseApprovalAction
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
        // Execute the SusuServiceFlexySusuCollectionPauseApprovalRequest and return the response
        $response = (new SusuServiceFlexySusuCollectionPauseApprovalRequest)->execute(
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
        // Execute the SusuServiceFlexySusuCollectionPauseCancellationRequest HTTP request
        $response = (new SusuServiceFlexySusuCollectionPauseCancellationRequest)->execute(
            customer: $session->customer,
            data: SusuServiceFlexySusuCollectionPauseCancellationData::toArray(),
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
