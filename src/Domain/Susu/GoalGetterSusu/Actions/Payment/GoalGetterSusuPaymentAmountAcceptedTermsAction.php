<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Payment;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\GoalGetterSusu\Payment\SusuServiceGoalGetterSusuPaymentAmountData;
use App\Services\Susu\Requests\GoalGetterSusu\Payment\SusuServiceGoalGetterSusuPaymentAmountRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Payment\SusuPaymentMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentAmountAcceptedTermsAction
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

        // Execute the SusuServiceGoalGetterSusuPaymentAmountRequest HTTP request and return the response
        $response = (new SusuServiceGoalGetterSusuPaymentAmountRequest)->execute(customer: $customer, data: SusuServiceGoalGetterSusuPaymentAmountData::toArray(user_inputs: $user_inputs), susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'));

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserData(session: $session, user_data: ['payment_data' => data_get(target: $response, key: 'data.attributes')]);

        // Return the noSususAccount
        return SusuPaymentMenu::paymentAmountNarrationMenu(session: $session, payment_data: $response);
    }
}
