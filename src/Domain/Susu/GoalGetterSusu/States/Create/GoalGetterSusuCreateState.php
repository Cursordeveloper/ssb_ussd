<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Create;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateAccountNameAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateApprovalAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateDurationAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateFrequencyAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateLinkedWalletAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateStartDateAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateTargetAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => GoalGetterSusuCreateAccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'target_amount', array: $process_flow) => GoalGetterSusuCreateTargetAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'duration', array: $process_flow) => GoalGetterSusuCreateDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'start_date', array: $process_flow) => GoalGetterSusuCreateStartDateAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => GoalGetterSusuCreateFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => GoalGetterSusuCreateLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => GoalGetterSusuCreateAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => GoalGetterSusuCreateApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
