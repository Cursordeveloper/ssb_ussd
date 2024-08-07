<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Pause;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\PersonalSusu\Pause\SusuServicePersonalSusuCollectionPauseData;
use App\Services\Susu\Requests\PersonalSusu\Pause\SusuServicePersonalSusuCollectionPauseRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Pause\PersonalSusuCollectionPauseMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionPauseAcceptedTermsAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Return the invalidAcceptedSusuTerms menu if user_input is not 1
        if ($session_data->user_input !== '1') {
            return GeneralMenu::invalidAcceptedSusuTerms(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true]);

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuCollectionPauseRequest HTTP request
        $response = (new SusuServicePersonalSusuCollectionPauseRequest)->execute(
            customer: $customer,
            data: SusuServicePersonalSusuCollectionPauseData::toArray(user_inputs: $user_inputs),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id')
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['collection_pause_data' => data_get(target: $response, key: 'data.attributes')]);

        // Return the noSususAccount
        return PersonalSusuCollectionPauseMenu::narrationMenu(session: $session, response: $response);
    }
}
