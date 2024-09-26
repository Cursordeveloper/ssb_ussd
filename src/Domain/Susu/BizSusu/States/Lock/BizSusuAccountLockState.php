<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Lock;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockApprovalAction;
use Domain\Susu\BizSusu\Actions\Lock\BizSusuAccountLockDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountLockState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $session->userInputs()) => BizSusuAccountLockDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuAccountLockAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuAccountLockApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
