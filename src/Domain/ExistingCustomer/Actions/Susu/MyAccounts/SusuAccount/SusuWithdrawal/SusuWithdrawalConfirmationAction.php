<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalConfirmationAction
{
    public static function execute($session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['withdrawal_amount' => $session_data->user_input]);

        // Get the customer
        //        $customer = GetCustomerAction::execute($session->phone_number);

        // Return the noSususAccount
        return GeneralMenu::requestNotification(session: $session);
    }
}
