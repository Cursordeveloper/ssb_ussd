<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Payment;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Payment\PersonalSusuPaymentFrequencyAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuPaymentState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'frequency', array: $user_inputs) => PersonalSusuPaymentFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => PersonalSusuPaymentAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => PersonalSusuPaymentApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
