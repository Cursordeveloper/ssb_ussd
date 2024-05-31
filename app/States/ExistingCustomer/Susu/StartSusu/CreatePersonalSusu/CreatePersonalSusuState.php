<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\StartSusu\CreatePersonalSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Common\CreateSusuRolloverAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu\CreatePersonalSusuAcceptedTermsAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu\CreatePersonalSusuAccountNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu\CreatePersonalSusuApprovalAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu\CreatePersonalSusuLinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu\CreatePersonalSusuSusuAmountAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreatePersonalSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'account_name', array: $process_flow) => CreatePersonalSusuAccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => CreatePersonalSusuSusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => CreatePersonalSusuLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'rollover', array: $process_flow) => CreateSusuRolloverAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => CreatePersonalSusuAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => CreatePersonalSusuApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
