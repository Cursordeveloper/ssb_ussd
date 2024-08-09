<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Withdrawal;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Data\BizSusu\Withdrawal\SusuServiceBizSusuWithdrawalFullData;
use App\Services\Susu\Data\BizSusu\Withdrawal\SusuServiceBizSusuWithdrawalPartialData;
use App\Services\Susu\Requests\BizSusu\Withdrawal\SusuServiceBizSusuWithdrawalFullRequest;
use App\Services\Susu\Requests\BizSusu\Withdrawal\SusuServiceBizSusuWithdrawalPartialRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\SusuWithdrawalMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalFullAcceptedTermsAction
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

        // Execute the SusuServiceBizSusuWithdrawalFullRequest HTTP request and return the response
        $response = (new SusuServiceBizSusuWithdrawalFullRequest)->execute(customer: $customer, data: SusuServiceBizSusuWithdrawalFullData::toArray(user_inputs: $user_inputs), susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'));

        // Terminate session if $get_balance request status is false
        if (data_get(target: $response, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['withdrawal_data' => data_get(target: $response, key: 'data.attributes')]);

        // Return the SusuWithdrawalMenu and return the withdrawalNarrationMenu
        return SusuWithdrawalMenu::withdrawalNarrationMenu(session: $session, withdrawal_data: $response);
    }
}
