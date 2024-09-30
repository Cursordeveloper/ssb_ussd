<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Payment;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentApprovalAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentFrequencyAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentFrequencyAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentFrequencyState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => GoalGetterSusuPaymentFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => GoalGetterSusuPaymentFrequencyAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => GoalGetterSusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
