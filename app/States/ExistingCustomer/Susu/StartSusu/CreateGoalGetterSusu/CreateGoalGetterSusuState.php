<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\StartSusu\CreateGoalGetterSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuAcceptedTermsAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuAccountNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuApprovalAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuDurationAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuFrequencyAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuLinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuStartDateAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu\CreateGoalGetterSusuTargetAmountAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => CreateGoalGetterSusuAccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'target_amount', array: $process_flow) => CreateGoalGetterSusuTargetAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'duration', array: $process_flow) => CreateGoalGetterSusuDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'start_date', array: $process_flow) => CreateGoalGetterSusuStartDateAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => CreateGoalGetterSusuFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => CreateGoalGetterSusuLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => CreateGoalGetterSusuAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => CreateGoalGetterSusuApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
