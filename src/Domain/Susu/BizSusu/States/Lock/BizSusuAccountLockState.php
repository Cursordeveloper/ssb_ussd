<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Lock;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockApprovalAction;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountLockState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $user_inputs) => BizSusuAccountLockDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => BizSusuAccountLockAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => BizSusuAccountLockApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
