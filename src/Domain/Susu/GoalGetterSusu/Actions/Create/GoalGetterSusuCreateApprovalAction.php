<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use App\Services\Susu\Data\GoalGetterSusu\Create\GoalGetterSusuCancellationData;
use App\Services\Susu\Requests\GoalGetterSusu\Create\GoalGetterSusuApprovalRequest;
use App\Services\Susu\Requests\GoalGetterSusu\Create\GoalGetterSusuCancellationRequest;
use Domain\Shared\Action\General\GeneralValidation;
use Domain\Shared\Data\Common\PinApprovalData;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateApprovalAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            $service_data->user_input === '2' => self::cancelExecution(session: $session),
            GeneralValidation::pinLengthValid($service_data->user_input) === false => GeneralMenu::pinLengthMenu(session: $session),

            default => self::approvalExecution(session: $session, service_data: $service_data)
        };
    }

    public static function approvalExecution(Session $session, $service_data): JsonResponse
    {
        // Execute the GoalGetterSusuApprovalRequest and return the response data
        $response = (new GoalGetterSusuApprovalRequest)->execute(
            customer: $session->customer,
            data: PinApprovalData::toArray($service_data->user_input),
            susu_resource: $session->userInputs()['susu_resource'],
        );

        // Process response and return menu
        return match (true) {
            data_get($response, key: 'code') === 200 => GeneralMenu::createAccountNotification(session: $session),
            data_get($response, key: 'code') === 401 => GeneralMenu::incorrectPinMenu(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function cancelExecution(Session $session): JsonResponse
    {
        // Execute the GoalGetterSusuCancellationRequest HTTP request
        (new GoalGetterSusuCancellationRequest)->execute(
            customer: $session->customer,
            data: GoalGetterSusuCancellationData::toArray(),
            susu_resource: $session->userInputs()['susu_resource'],
        );

        // Return the processCancelNotification and terminate the session
        return GeneralMenu::processCancelNotification(session: $session);
    }
}
