<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Withdrawal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalApprovalAction;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalPartialAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalPartialAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalPartialState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'withdrawal_amount', array: $session->userInputs()) => BizSusuWithdrawalPartialAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuWithdrawalPartialAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuWithdrawalApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
