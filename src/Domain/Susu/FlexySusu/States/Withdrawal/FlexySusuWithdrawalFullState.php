<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Withdrawal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalApprovalAction;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalFullAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalFullConfirmationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuWithdrawalFullState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => FlexySusuWithdrawalFullConfirmationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => FlexySusuWithdrawalFullAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => FlexySusuWithdrawalApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
