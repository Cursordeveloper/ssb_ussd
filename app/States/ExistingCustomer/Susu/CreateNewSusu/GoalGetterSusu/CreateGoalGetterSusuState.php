<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\ConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\FrequencyAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\LinkedWalletAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\StartDateAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\TargetAmountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\TargetDurationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\TheGoalAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'goal', array: $process_flow) => TheGoalAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'amount', array: $process_flow) => TargetAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'duration', array: $process_flow) => TargetDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'start_date', array: $process_flow) => StartDateAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => FrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'wallet', array: $process_flow) => LinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'confirmation', array: $process_flow) => ConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
