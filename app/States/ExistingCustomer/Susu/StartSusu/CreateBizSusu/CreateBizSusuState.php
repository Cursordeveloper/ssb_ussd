<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\StartSusu\CreateBizSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuAcceptedTermsAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuApprovalAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuBusinessNameAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuFrequencyAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuLinkedWalletAction;
use Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu\CreateBizSusuSusuAmountAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'business_name', array: $process_flow) => CreateBizSusuBusinessNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susu_amount', array: $process_flow) => CreateBizSusuSusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'frequency', array: $process_flow) => CreateBizSusuFrequencyAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'linked_wallet', array: $process_flow) => CreateBizSusuLinkedWalletAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accepted_terms', array: $process_flow) => CreateBizSusuAcceptedTermsAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'approval', array: $process_flow) => CreateBizSusuApprovalAction::execute(session: $session, session_data: $session_data),

            default => GeneralMenu::systemErrorNotification(session: $session),
        };
    }
}
