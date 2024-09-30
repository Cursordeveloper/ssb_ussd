<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Payment;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentAmountAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentAmountAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentAmountState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'amount', array: $session->userInputs()) => GoalGetterSusuPaymentAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => GoalGetterSusuPaymentAmountAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => GoalGetterSusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
