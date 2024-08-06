<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuMiniStatement;

use App\Menus\Shared\GeneralMenu;
use App\Services\Susu\Requests\Susu\Transaction\SusuServiceSusuTransactionsRequest;
use Domain\Shared\Action\Customer\GetCustomerAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\SusuMiniStatementMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementAction
{
    public static function execute(Session $session, $user_inputs): JsonResponse
    {
        // Get the customer
        $customer = GetCustomerAction::execute($session->phone_number);

        // Execute the createPersonalSusu HTTP request
        $transactions = (new SusuServiceSusuTransactionsRequest)->execute(
            customer: $customer,
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'),
        );

        // Match statement to determine the response based on transaction status and data
        return match (true) {
            data_get(target: $transactions, key: 'code') !== 200 => GeneralMenu::invalidInput(session: $session),
            empty(data_get(target: $transactions, key: 'data')) => SusuMiniStatementMenu::susuNoMiniStatementMenu(session: $session),

            default => SusuMiniStatementMenu::susuMiniStatementMenu(session: $session, transactions: $transactions),
        };
    }
}
