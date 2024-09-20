<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Lock;

use App\Services\Susu\Data\FlexySusu\Lock\SusuServiceFlexySusuAccountLockData;
use App\Services\Susu\Requests\FlexySusu\Lock\SusuServiceFlexySusuAccountLockRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Lock\FlexySusuAccountLockMenu;
use Domain\User\Customer\Actions\Common\GetCustomerAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountLockAcceptedTermsAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Return the invalidAcceptedSusuTerms menu if user_input is not 1
        if ($service_data->user_input !== '1') {
            return GeneralMenu::invalidAcceptedSusuTerms(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['accepted_terms' => true]);

        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the SusuServiceFlexySusuAccountLockRequest HTTP request
        $response = (new SusuServiceFlexySusuAccountLockRequest)->execute(
            customer: $customer,
            data: SusuServiceFlexySusuAccountLockData::toArray(user_inputs: $user_inputs),
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id')
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_lock_data' => data_get(target: $response, key: 'data.attributes')]);

        // Return the noSususAccount
        return FlexySusuAccountLockMenu::narrationMenu(session: $session, response: $response);
    }
}
