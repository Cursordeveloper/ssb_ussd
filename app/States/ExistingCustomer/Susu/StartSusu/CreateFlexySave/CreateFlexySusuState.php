<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\StartSusu\CreateFlexySave;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\AccountNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\ConfirmationAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\FrequencyAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\LinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\MaxAmountAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\MinAmountAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\RecurringDebitAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => AccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'min_amount', array: $process_flow) => MinAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'max_amount', array: $process_flow) => MaxAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => FrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'recurring_debit', array: $process_flow) => RecurringDebitAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
