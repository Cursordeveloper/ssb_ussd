<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Collection\Summary;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Collection\Summary\PersonalSusuCollectionSummaryApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionSummaryState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'approval', array: $user_inputs) => PersonalSusuCollectionSummaryApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
