<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Payment;

use App\Services\Susu\Data\GoalGetterSusu\Payment\SusuServiceGoalGetterSusuPaymentFrequencyData;
use App\Services\Susu\Requests\GoalGetterSusu\Payment\SusuServiceGoalGetterSusuPaymentFrequencyRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Payment\SusuPaymentMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentFrequencyAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::actionExecution(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    private static function actionExecution(Session $session): JsonResponse
    {
        // Execute the SusuServiceGoalGetterSusuPaymentFrequencyRequest HTTP request
        $response = (new SusuServiceGoalGetterSusuPaymentFrequencyRequest)->execute(
            customer: $session->customer,
            data: SusuServiceGoalGetterSusuPaymentFrequencyData::toArray(user_inputs: $session->userInputs()),
            susu_resource: data_get(target: $session->userInputs(), key: 'susu_account.attributes.resource_id'),
        );

        // Update the user_put and return the narrationMenu
        if (data_get($response, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'payment_resource' => data_get(target: $response, key: 'data.attributes.resource_id')]);
            return SusuPaymentMenu::paymentFrequencyNarrationMenu(session: $session, payment_data: $response);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
