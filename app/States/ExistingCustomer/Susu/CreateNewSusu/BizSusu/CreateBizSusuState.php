<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu\BusinessNameAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu\ConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu\DebitFrequencyAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu\LinkedWalletAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu\SusuAmountAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'BusinessName', array: $process_flow) => BusinessNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'SusuAmount', array: $process_flow) => SusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'Frequency', array: $process_flow) => DebitFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'LinkedWallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'Confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
