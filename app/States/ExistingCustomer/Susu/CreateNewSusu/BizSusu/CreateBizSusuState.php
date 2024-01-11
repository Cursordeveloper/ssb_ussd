<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\BizSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\BusinessNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\ConfirmationAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\FrequencyAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\LinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\SusuAmountAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'business_name', array: $process_flow) => BusinessNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => SusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => FrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'wallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
