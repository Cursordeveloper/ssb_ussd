<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal\SusuWithdrawalMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalAction
{
    public static function execute($session): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_withdrawal' => true]);

        // Return the noSususAccount
        return SusuWithdrawalMenu::withdrawalAmountMenu(session: $session);
    }
}
