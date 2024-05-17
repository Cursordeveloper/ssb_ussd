<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuAccountWithdrawalMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalAmountAction
{
    public static function execute($session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['withdrawal_amount' => $session_data->user_input]);

        // Return the noSususAccount
        return SusuAccountWithdrawalMenu::narrationMenu(session: $session);
    }
}
