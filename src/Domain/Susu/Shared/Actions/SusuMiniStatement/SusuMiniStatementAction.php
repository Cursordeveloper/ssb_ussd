<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\SusuMiniStatement;

use App\Services\Susu\Requests\Susu\Transaction\SusuServiceSusuNextTransactionsRequest;
use App\Services\Susu\Requests\Susu\Transaction\SusuServiceSusuTransactionsRequest;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Statement\SusuMiniStatementMenu;
use Domain\User\Customer\Models\Customer;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementAction
{
    public static function newTransaction(Session $session, Customer $customer, array $user_inputs): JsonResponse
    {
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

    public static function nextTransaction(Session $session, Customer $customer, array $user_inputs, int $page): JsonResponse
    {
        // Update next page
        $page++;

        // Execute the createPersonalSusu HTTP request
        $transactions = (new SusuServiceSusuNextTransactionsRequest)->execute(
            customer: $customer,
            susu_resource: data_get(target: $user_inputs, key: 'susu_account.attributes.resource_id'),
            page: $page,
        );

        // Update the user_inputs (page)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['page' => $page]);

        // Match statement to determine the response based on transaction status and data
        return match (true) {
            data_get(target: $transactions, key: 'code') !== 200 => GeneralMenu::invalidInput(session: $session),
            empty(data_get(target: $transactions, key: 'data')) => SusuMiniStatementMenu::susuNoMiniStatementMenu(session: $session),
            $page === 5 => SusuMiniStatementMenu::susuMiniStatementEndMenu(session: $session, transactions: $transactions),

            default => SusuMiniStatementMenu::susuMiniStatementMenu(session: $session, transactions: $transactions),
        };
    }
}
