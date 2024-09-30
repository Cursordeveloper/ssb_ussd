<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Payment;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentAmountAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentAmountAction;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuPaymentState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'amount', array: $session->userInputs()) => FlexySusuPaymentAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => FlexySusuPaymentAmountAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => FlexySusuPaymentApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
