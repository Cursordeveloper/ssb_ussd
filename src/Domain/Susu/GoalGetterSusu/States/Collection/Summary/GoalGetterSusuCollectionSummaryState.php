<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Collection\Summary;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Collection\Summary\PersonalSusuCollectionSummaryApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCollectionSummaryState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'approval', array: $user_inputs) => PersonalSusuCollectionSummaryApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
