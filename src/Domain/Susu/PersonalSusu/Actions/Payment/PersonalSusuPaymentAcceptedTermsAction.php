<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Payment;

use App\Services\Susu\Data\PersonalSusu\Payment\SusuServicePersonalSusuPaymentData;
use App\Services\Susu\Requests\PersonalSusu\Payment\SusuServicePersonalSusuPaymentRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Payment\PersonalSusuPaymentMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $service_data->user_input === '1' => self::susuPaymentProcessor(session: $session),
            $service_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => GeneralMenu::invalidAcceptedSusuTerms(session: $session)
        };
    }

    public static function susuPaymentProcessor(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Execute and return the customer data
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServicePersonalSusuPaymentRequest HTTP request
        $payment_data = (new SusuServicePersonalSusuPaymentRequest)->execute(customer: $customer, data: SusuServicePersonalSusuPaymentData::toArray(user_inputs: $user_inputs), susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'));

        // Update the user_put and return the narrationMenu
        if (data_get($payment_data, key: 'code') === 200) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true, 'payment_resource' => data_get(target: $payment_data, key: 'data.attributes.resource_id')]);
            return PersonalSusuPaymentMenu::narrationMenu(session: $session, payment_data: $payment_data);
        }

        // Return the invalidInput
        return GeneralMenu::systemErrorNotification(session: $session);
    }
}
