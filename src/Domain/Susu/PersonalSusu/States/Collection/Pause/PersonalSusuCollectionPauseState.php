<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Collection\Pause;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Collection\Pause\PersonalSusuCollectionPauseAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Collection\Pause\PersonalSusuCollectionPauseApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Collection\Pause\PersonalSusuPauseDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCollectionPauseState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $session->userInputs()) => PersonalSusuPauseDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => PersonalSusuCollectionPauseAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => PersonalSusuCollectionPauseApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
