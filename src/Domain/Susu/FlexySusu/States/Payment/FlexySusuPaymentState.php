<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Payment;

use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentAmountAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentAmountAction;
use Domain\Susu\FlexySusu\Actions\Payment\FlexySusuPaymentApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'amount', array: $user_inputs) => FlexySusuPaymentAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => FlexySusuPaymentAmountAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => FlexySusuPaymentApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
