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
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'frequency', array: $user_inputs) => BizSusuPaymentFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => BizSusuPaymentFrequencyAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => BizSusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
