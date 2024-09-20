<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Lock;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Lock\FlexySusuAccountLockAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Lock\FlexySusuAccountLockApprovalAction;
use Domain\Susu\FlexySusu\Actions\Lock\FlexySusuAccountLockDurationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountLockState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'duration', array: $user_inputs) => FlexySusuAccountLockDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => FlexySusuAccountLockAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => FlexySusuAccountLockApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
