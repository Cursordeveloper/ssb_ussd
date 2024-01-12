<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal\ProcessStartAction;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal\WithdrawalAmountAction;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuWithdrawal\WithdrawalConfirmationAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'process_start', array: $user_inputs) => ProcessStartAction::execute(session: $session),
            ! array_key_exists(key: 'withdrawal_amount', array: $user_inputs) => WithdrawalAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => WithdrawalConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
