<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\AccountNameAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\ConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\LinkedWalletAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\SusuAmountAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePersonalSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => AccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'amount', array: $process_flow) => SusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'wallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
