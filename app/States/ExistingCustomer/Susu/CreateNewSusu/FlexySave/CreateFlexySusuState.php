<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\AccountNameAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\ConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\EndAmountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\FrequencyAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\LinkedWalletAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\StartAmountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave\StrictDebitAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'AccountName', array: $process_flow) => AccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'StartAmount', array: $process_flow) => StartAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'EndAmount', array: $process_flow) => EndAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'Frequency', array: $process_flow) => FrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'StrictDebit', array: $process_flow) => StrictDebitAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'LinkedWallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'Confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
