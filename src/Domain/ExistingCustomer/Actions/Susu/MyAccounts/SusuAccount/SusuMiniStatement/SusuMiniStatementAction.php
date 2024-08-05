<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuMiniStatement;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\Transaction\SusuServiceSusuTransactionsRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\SusuMiniStatementMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementAction
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
        $transactions = (new SusuServiceSusuTransactionsRequest)->execute(
            customer: $customer,
            susu_resource: data_get(target: $susu_account, key: 'susu_account.attributes.resource_id'),
        );

        // Terminate session if $transactions request status is false
        if (data_get(target: $transactions, key: 'code') !== 200) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Terminate session if [$statements['data']] return info and terminate the session
        if (empty(data_get($transactions, key: 'data'))) {
            return SusuMiniStatementMenu::susuNoMiniStatementMenu(session: $session);
        }

        // Prepare the and return the susu accounts
        return SusuMiniStatementMenu::susuMiniStatementMenu(session: $session, transactions: $transactions);
    }
}
