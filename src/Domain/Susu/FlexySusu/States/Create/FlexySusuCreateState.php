<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\States\Create;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuAcceptedTermsAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuAccountNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuApprovalAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuFrequencyAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuLinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu\CreateFlexySusuSusuAmountAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => CreateFlexySusuAccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => CreateFlexySusuSusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => CreateFlexySusuFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => CreateFlexySusuLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => CreateFlexySusuAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => CreateFlexySusuApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
