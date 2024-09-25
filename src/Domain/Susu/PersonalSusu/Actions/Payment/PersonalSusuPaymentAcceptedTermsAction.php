<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Payment;

use App\Services\Susu\Data\PersonalSusu\Payment\SusuServicePersonalSusuPaymentData;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Payment\PersonalSusuPaymentMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentAcceptedTermsAction
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

    private static function stateExecution(Session $session): JsonResponse
    {
        // Execute the SusuServicePersonalSusuPaymentRequest HTTP request
        $response = (new SusuServicePersonalSusuPaymentRequest)->execute(customer: $session->customer, data: SusuServicePersonalSusuPaymentData::toArray(user_inputs: $session->userInputs()), susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'));

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'payment_resource' => data_get(target: $response, key: 'data.attributes.resource_id')]);
            return PersonalSusuPaymentMenu::narrationMenu(session: $session, payment_data: $response);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
