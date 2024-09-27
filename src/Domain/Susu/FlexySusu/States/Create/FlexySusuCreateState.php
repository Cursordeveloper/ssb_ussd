<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Create;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateAcceptedTermsAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateAccountNameAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateApprovalAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateFrequencyAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateInitialDepositAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateLinkedWalletAction;
use Domain\Susu\FlexySusu\Actions\Create\FlexySusuCreateSusuAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $session->userInputs()) => FlexySusuCreateAccountNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'susu_amount', array: $session->userInputs()) => FlexySusuCreateSusuAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'initial_deposit', array: $session->userInputs()) => FlexySusuCreateInitialDepositAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => FlexySusuCreateFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'linked_wallet', array: $session->userInputs()) => FlexySusuCreateLinkedWalletAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => FlexySusuCreateAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => FlexySusuCreateApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
