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
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'total_cycle', array: $session->userInputs()) => PersonalSusuSettlementPendingTotalCycleAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => PersonalSusuSettlementPendingAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approved', array: $session->userInputs()) => PersonalSusuSettlementApprovalAction::execute(session: $session, service_data: $service_data),
            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
