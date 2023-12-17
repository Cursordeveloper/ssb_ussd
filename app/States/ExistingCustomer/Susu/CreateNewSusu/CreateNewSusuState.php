<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\AccountNameAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\AccountSummaryAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\ChooseLinkedAccountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\ChooseSusuSchemeAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\CreateNewSusuAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PinConfirmationAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\SusuAmountAction;
use Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\TermsAgreementAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $process_flow = json_decode($session->user_inputs, associative: true);

        // Evaluate the process flow and execute the corresponding action
        return match (true) {
            ! array_key_exists(key: 'beginProcess', array: $process_flow) => CreateNewSusuAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'chooseScheme', array: $process_flow) => ChooseSusuSchemeAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accountName', array: $process_flow) => AccountNameAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'susuAmount', array: $process_flow) => SusuAmountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'ChooseLinkedWallet', array: $process_flow) => ChooseLinkedAccountAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'acceptTermsConditions', array: $process_flow) => TermsAgreementAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'accountSummary', array: $process_flow) => AccountSummaryAction::execute(session: $session, session_data: $session_data),
            ! array_key_exists(key: 'pinConfirmation', array: $process_flow) => PinConfirmationAction::execute(session: $session, session_data: $session_data),
            default => GeneralMenu::infoNotification(
                message: 'There was a problem. Try again later.',
                session: data_get(target: $session, key: 'session_id')
            ),
        };
    }
}
