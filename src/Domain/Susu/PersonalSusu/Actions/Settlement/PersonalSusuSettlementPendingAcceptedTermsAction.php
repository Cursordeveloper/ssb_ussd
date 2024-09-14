<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use App\Services\Susu\Data\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementPendingData;
use App\Services\Susu\Requests\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementPendingRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementPendingMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingAcceptedTermsAction
{
    public static function execute(Session $session, $user_inputs, $session_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $session_data->user_input === '1' => self::susuSettlementProcessor(session: $session, user_inputs: $user_inputs),
            $session_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuSettlementProcessor(Session $session, array $user_inputs): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $settlement_data = (new SusuServicePersonalSusuSettlementPendingRequest)->execute(
            customer: $customer,
            data: SusuServicePersonalSusuSettlementPendingData::toArray(user_inputs: $user_inputs),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id')
        );

        // Update the user_put and return the narrationMenu
        if (data_get($settlement_data, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'settlement_resource' => data_get(target: $settlement_data, key: 'data.attributes.resource_id')]);
            return PersonalSusuSettlementPendingMenu::narrationMenu(session: $session, data: $settlement_data);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
