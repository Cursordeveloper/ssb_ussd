<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use App\Services\Susu\Data\FlexySusu\Create\FlexySusuCreateData;
use App\Services\Susu\Requests\FlexySusu\Create\FlexySusuCreateRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            $service_data->user_input === '1' => self::susuCreateRequest(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processCancelNotification(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuCreateRequest(Session $session): JsonResponse
    {
        // Execute the FlexySusuCreateRequest HTTP request
        $response = (new FlexySusuCreateRequest)->execute(
            customer: $session->customer,
            data: FlexySusuCreateData::toArray(user_inputs: $session->userInputs())
        );

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($response, key: 'data.attributes.resource_id')]);
            return FlexySusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($response, key: 'data.attributes'), linked_account: data_get($response, key: 'data.included.wallet.attributes'));
        }

        // Return the invalidInput
        return GeneralMenu::invalidInput(session: $session);
    }
}
