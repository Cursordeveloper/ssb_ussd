<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use App\Services\Susu\Data\BizSusu\Create\BizSusuCreateData;
use App\Services\Susu\Requests\BizSusu\Create\BizSusuCreateRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Create\BizSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateAcceptedTermsAction
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
        // Execute the BizSusuCreateRequest HTTP request
        $response = (new BizSusuCreateRequest)->execute(
            customer: $session->customer,
            data: BizSusuCreateData::toArray(user_inputs: $session->userInputs()),
        );

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'susu_resource' => data_get($response, key: 'data.attributes.resource_id')]);
            return BizSusuCreateMenu::narrationMenu(session: $session, susu_data: data_get($response, key: 'data.attributes'), linked_account: data_get($response, key: 'data.included.wallet.attributes'));
        }

        // Return system error menu
        return GeneralMenu::invalidInput(session: $session);
    }
}
