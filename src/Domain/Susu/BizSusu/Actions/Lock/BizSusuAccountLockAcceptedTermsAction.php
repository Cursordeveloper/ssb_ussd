<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Lock;

use App\Services\Susu\Data\BizSusu\Lock\SusuServiceBizSusuAccountLockData;
use App\Services\Susu\Requests\BizSusu\Lock\SusuServiceBizSusuAccountLockRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Lock\BizSusuAccountLockMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountLockAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::stateExecution(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function stateExecution(Session $session): JsonResponse
    {
        // Execute the SusuServicePersonalSusuAccountLockRequest HTTP request
        $response = (new SusuServiceBizSusuAccountLockRequest)->execute(
            customer: $session->customer,
            data: SusuServiceBizSusuAccountLockData::toArray(user_inputs: $session->userInputs()),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id')
        );

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'account_lock_data' => data_get(target: $response, key: 'data.attributes')]);
            return BizSusuAccountLockMenu::narrationMenu(session: $session, response: $response);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
