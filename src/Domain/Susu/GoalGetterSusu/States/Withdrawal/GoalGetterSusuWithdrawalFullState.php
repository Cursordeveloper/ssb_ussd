<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Withdrawal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Withdrawal\GoalGetterSusuWithdrawalApprovalAction;
use Domain\Susu\GoalGetterSusu\Actions\Withdrawal\GoalGetterSusuWithdrawalFullAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Withdrawal\GoalGetterSusuWithdrawalFullConfirmationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuWithdrawalFullState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => GoalGetterSusuWithdrawalFullConfirmationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => GoalGetterSusuWithdrawalFullAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => GoalGetterSusuWithdrawalApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
