<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Withdrawal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalApprovalAction;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalPartialAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Withdrawal\FlexySusuWithdrawalPartialAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuWithdrawalPartialState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'withdrawal_amount', array: $session->userInputs()) => FlexySusuWithdrawalPartialAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => FlexySusuWithdrawalPartialAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => FlexySusuWithdrawalApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
