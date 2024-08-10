<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Payment;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentAmountAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentAmountAction;
use Domain\Susu\GoalGetterSusu\Actions\Payment\GoalGetterSusuPaymentApprovalAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuPaymentAmountState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'amount', array: $user_inputs) => GoalGetterSusuPaymentAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $user_inputs) => GoalGetterSusuPaymentAmountAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $user_inputs) => GoalGetterSusuPaymentApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
