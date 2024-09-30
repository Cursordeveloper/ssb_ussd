<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Collection\Goal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Collection\Summary\PersonalSusuCollectionSummaryApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuGoalSummaryState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => PersonalSusuCollectionSummaryApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
