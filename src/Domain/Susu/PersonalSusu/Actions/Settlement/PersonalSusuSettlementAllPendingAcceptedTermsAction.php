<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use App\Services\Susu\Data\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementData;
use App\Services\Susu\Requests\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementAllPendingRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementAllPendingMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementAllPendingAcceptedTermsAction
{
    public static function execute($session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::susuSettlementProcessor(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuSettlementProcessor(Session $session): JsonResponse
    {
        // Execute the createPersonalSusu HTTP request
        $settlement_data = (new SusuServicePersonalSusuSettlementAllPendingRequest)->execute(
            customer: $session->customer,
            data: SusuServicePersonalSusuSettlementData::toArray(user_inputs: $session->userInputs()),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id')
        );

        // Update the user_put and return the narrationMenu
        if (data_get($settlement_data, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'settlement_resource' => data_get(target: $settlement_data, key: 'data.attributes.resource_id')]);
            return PersonalSusuSettlementAllPendingMenu::narrationMenu(session: $session, data: $settlement_data);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
