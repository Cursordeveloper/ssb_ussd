<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Settlement;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementPendingAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Settlement\PersonalSusuSettlementPendingTotalCycleAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'total_cycle', array: $user_inputs) => PersonalSusuSettlementPendingTotalCycleAction::execute(session: $session, user_inputs: $user_inputs, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => PersonalSusuSettlementPendingAcceptedTermsAction::execute(session: $session, user_inputs: $user_inputs, service_data: $service_data),
            ! array_key_exists(key: 'approved', array: $user_inputs) => PersonalSusuSettlementApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
