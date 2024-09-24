<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Payment;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentFrequencyAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => PersonalSusuPaymentFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => PersonalSusuPaymentAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => PersonalSusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
