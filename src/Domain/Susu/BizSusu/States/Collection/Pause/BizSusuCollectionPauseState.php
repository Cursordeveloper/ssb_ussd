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
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $session->userInputs()) => BizSusuPauseDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuCollectionPauseAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuCollectionPauseApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
