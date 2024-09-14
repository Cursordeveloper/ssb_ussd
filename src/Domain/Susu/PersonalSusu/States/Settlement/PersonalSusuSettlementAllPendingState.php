<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Settlement;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementAllPendingAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementAllPendingConfirmationAction;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementAllPendingState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'confirmation', array: $user_inputs) => PersonalSusuSettlementAllPendingConfirmationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => PersonalSusuSettlementAllPendingAcceptedTermsAction::execute(session: $session, user_inputs: $user_inputs, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => PersonalSusuSettlementApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
