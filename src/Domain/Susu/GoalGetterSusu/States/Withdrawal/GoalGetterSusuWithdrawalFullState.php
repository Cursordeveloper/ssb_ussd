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
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'confirmation', array: $session->userInputs()) => GoalGetterSusuWithdrawalFullConfirmationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => GoalGetterSusuWithdrawalFullAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => GoalGetterSusuWithdrawalApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
