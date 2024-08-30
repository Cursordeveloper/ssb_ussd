<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Collection\Pause;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Collection\Pause\BizSusuCollectionPauseAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Collection\Pause\BizSusuCollectionPauseApprovalAction;
use Domain\Susu\BizSusu\Actions\Collection\Pause\BizSusuPauseDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCollectionPauseState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $user_inputs) => BizSusuPauseDurationAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => BizSusuCollectionPauseAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => BizSusuCollectionPauseApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
