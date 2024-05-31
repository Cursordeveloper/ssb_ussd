<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared\SusuAccountBalanceMenu;
use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\SusuServiceSusuBalanceRequest;
use Domain\ExistingCustomer\Data\Common\PinApprovalData;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['approval' => true]);

        // Get the process flow array from the customer session (user inputs)
        $susu_account = json_decode($session->user_inputs, associative: true);

        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $balances = (new SusuServiceSusuBalanceRequest)->execute(
            customer: $customer,
            susu_resource: data_get(target: $susu_account, key: 'susu_account.resource_id'),
            data: PinApprovalData::toArray($session_data->user_input),
        );

        // Terminate session if $get_balance request status is false
        if (data_get(target: $balances, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Prepare the and return the susu accounts
        if (! empty(data_get($balances, key: 'data'))) {
            return SusuAccountBalanceMenu::susuBalanceMenu(session: $session, susu_data: data_get(target: $balances, key: 'data.attributes'));
        }

        // Return the noSususAccount
        return GeneralMenu::invalidInput(session: $session);
    }
}
