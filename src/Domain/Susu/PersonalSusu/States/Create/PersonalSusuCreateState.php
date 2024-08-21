<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\States\Create;

use Domain\Shared\Action\Susu\CreateSusuRolloverAction;
use Domain\Shared\Menus\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateAcceptedTermsAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateAccountNameAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateApprovalAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateLinkedWalletAction;
use Domain\Susu\PersonalSusu\Actions\Create\PersonalSusuCreateSusuAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => PersonalSusuCreateAccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => PersonalSusuCreateSusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => PersonalSusuCreateLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'rollover', array: $process_flow) => CreateSusuRolloverAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => PersonalSusuCreateAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => PersonalSusuCreateApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
