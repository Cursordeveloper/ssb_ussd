<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\States\Create;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateAcceptedTermsAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateAccountNameAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateApprovalAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateDurationAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateFrequencyAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateInitialDepositAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateLinkedWalletAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateStartDateAction;
use Domain\Susu\GoalGetterSusu\Actions\Create\GoalGetterSusuCreateTargetAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $session->userInputs()) => GoalGetterSusuCreateAccountNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'target_amount', array: $session->userInputs()) => GoalGetterSusuCreateTargetAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'initial_deposit', array: $session->userInputs()) => GoalGetterSusuCreateInitialDepositAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'duration', array: $session->userInputs()) => GoalGetterSusuCreateDurationAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'start_date', array: $session->userInputs()) => GoalGetterSusuCreateStartDateAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'frequency', array: $session->userInputs()) => GoalGetterSusuCreateFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'linked_wallet', array: $session->userInputs()) => GoalGetterSusuCreateLinkedWalletAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => GoalGetterSusuCreateAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => GoalGetterSusuCreateApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
