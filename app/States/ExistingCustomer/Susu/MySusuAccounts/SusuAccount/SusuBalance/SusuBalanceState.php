<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance\SusuBalanceAction;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance\SusuBalanceConfirmationAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'susu_balance', array: $user_inputs) => SusuBalanceAction::execute(session: $session),
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => SusuBalanceConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
