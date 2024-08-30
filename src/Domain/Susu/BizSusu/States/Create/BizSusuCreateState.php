<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\States\Create;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateAcceptedTermsAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateApprovalAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateBusinessNameAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateFrequencyAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateLinkedWalletAction;
use Domain\Susu\BizSusu\Actions\Create\BizSusuCreateSusuAmountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'business_name', array: $process_flow) => BizSusuCreateBusinessNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => BizSusuCreateSusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => BizSusuCreateFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => BizSusuCreateLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => BizSusuCreateAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => BizSusuCreateApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
