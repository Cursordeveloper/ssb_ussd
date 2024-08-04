<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementPendingData;
use App\Services\Susu\Requests\PersonalSusu\Settlement\SusuServicePersonalSusuSettlementPendingRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementPendingMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingAcceptedTermsAction
{
    public static function execute($session, $user_inputs, $session_data): JsonResponse
    {
        // Return the invalidAcceptedSusuTerms menu if user_input is not 1
        if ($session_data->user_input !== '1') {
            return GeneralMenu::invalidAcceptedSusuTerms(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true]);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $settlement = (new SusuServicePersonalSusuSettlementPendingRequest)->execute(
            customer: $customer,
            data: SusuServicePersonalSusuSettlementPendingData::toArray(user_inputs: $user_inputs),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id')
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $settlement, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['settlement_data' => data_get(target: $settlement, key: 'data.attributes')]);

        // Return the noSususAccount
        return PersonalSusuSettlementPendingMenu::narrationMenu(session: $session, data: $settlement);
    }
}
