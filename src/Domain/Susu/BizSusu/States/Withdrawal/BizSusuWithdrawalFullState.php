<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Withdrawal;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalApprovalAction;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalFullAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Withdrawal\BizSusuWithdrawalFullConfirmationAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalFullState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'confirmation', array: $session->userInputs()) => BizSusuWithdrawalFullConfirmationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuWithdrawalFullAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuWithdrawalApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
