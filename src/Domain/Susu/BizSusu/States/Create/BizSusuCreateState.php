<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Create;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateApprovalAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateBusinessNameAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateFrequencyAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateInitialDepositAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateLinkedWalletAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateSusuAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'business_name', array: $session->userInputs()) => BizSusuCreateBusinessNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'susu_amount', array: $session->userInputs()) => BizSusuCreateSusuAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => BizSusuCreateFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'initial_deposit', array: $session->userInputs()) => BizSusuCreateInitialDepositAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'linked_wallet', array: $session->userInputs()) => BizSusuCreateLinkedWalletAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => BizSusuCreateAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => BizSusuCreateApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
