<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Collection\Pause;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Collection\Pause\FlexySusuCollectionPauseAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Collection\Pause\FlexySusuCollectionPauseApprovalAction;
use Domain\Susu\FlexySusu\Actions\Collection\Pause\FlexySusuPauseDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCollectionPauseState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $session->userInputs()) => FlexySusuPauseDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => FlexySusuCollectionPauseAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => FlexySusuCollectionPauseApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
