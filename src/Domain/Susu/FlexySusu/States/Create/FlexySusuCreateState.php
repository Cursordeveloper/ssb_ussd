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
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => FlexySusuCreateAccountNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => FlexySusuCreateSusuAmountAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'initial_deposit', array: $process_flow) => FlexySusuCreateInitialDepositAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => FlexySusuCreateFrequencyAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => FlexySusuCreateLinkedWalletAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => FlexySusuCreateAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => FlexySusuCreateApprovalAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
