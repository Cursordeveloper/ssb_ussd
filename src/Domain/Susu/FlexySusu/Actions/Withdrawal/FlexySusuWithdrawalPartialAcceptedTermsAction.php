<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Withdrawal;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\FlexySusu\Withdrawal\SusuServiceFlexySusuWithdrawalPartialData;
use App\Services\Susu\Requests\FlexySusu\Withdrawal\SusuServiceFlexySusuWithdrawalPartialRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Withdrawal\SusuWithdrawalMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuWithdrawalPartialAcceptedTermsAction
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

        // Execute the SusuServiceFlexySusuWithdrawalPartialRequest HTTP request and return the response
        $response = (new SusuServiceFlexySusuWithdrawalPartialRequest)->execute(customer: $customer, data: SusuServiceFlexySusuWithdrawalPartialData::toArray(user_inputs: $user_inputs), susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'));

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['withdrawal_data' => data_get(target: $response, key: 'data.attributes')]);

        // Return the withdrawalAmountNarrationMenu
        return SusuWithdrawalMenu::withdrawalNarrationMenu(session: $session, withdrawal_data: $response);
    }
}
