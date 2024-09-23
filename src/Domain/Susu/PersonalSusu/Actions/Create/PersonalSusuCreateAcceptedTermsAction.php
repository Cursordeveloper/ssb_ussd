<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use App\Services\Susu\Data\PersonalSusu\Create\PersonalSusuCreateData;
use App\Services\Susu\Requests\PersonalSusu\Create\PersonalSusuCreateRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::susuCreateRequest(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),
            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuCreateRequest(Session $session): JsonResponse
    {
        // Execute the PersonalSusuCreateRequest HTTP request
        $response = (new PersonalSusuCreateRequest)->execute(customer: $session->customer, data: PersonalSusuCreateData::toArray(json_decode($session->user_inputs, associative: true)));

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($response, key: 'data.attributes.resource_id')]);
            return PersonalSusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($response, key: 'data.attributes'), linked_account: data_get($response, key: 'data.included.wallet.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
