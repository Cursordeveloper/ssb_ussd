<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Lock;

use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Lock\PersonalSusuAccountLockAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Lock\PersonalSusuAccountLockApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Lock\PersonalSusuAccountLockDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuAccountLockState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $user_inputs) => PersonalSusuAccountLockDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => PersonalSusuAccountLockAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => PersonalSusuAccountLockApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
