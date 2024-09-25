<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Payment;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Payment\BizSusuPaymentApprovalAction;
use Domain\Susu\BizSusu\Actions\Payment\BizSusuPaymentFrequencyAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Payment\BizSusuPaymentFrequencyAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuPaymentFrequencyState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => BizSusuPaymentFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuPaymentFrequencyAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
