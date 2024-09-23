<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Create;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateAccountNameAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateInitialDepositAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateLinkedWalletAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateSusuAmountAction;
use Domain\Susu\Shared\Actions\Common\CreateSusuRolloverAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $session->userInputs()) => PersonalSusuCreateAccountNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'susu_amount', array: $session->userInputs()) => PersonalSusuCreateSusuAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'initial_deposit', array: $session->userInputs()) => PersonalSusuCreateInitialDepositAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'linked_wallet', array: $session->userInputs()) => PersonalSusuCreateLinkedWalletAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'rollover', array: $session->userInputs()) => CreateSusuRolloverAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => PersonalSusuCreateAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $session->userInputs()) => PersonalSusuCreateApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
