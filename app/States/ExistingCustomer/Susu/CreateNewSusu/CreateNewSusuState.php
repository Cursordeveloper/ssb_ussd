<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Susu\CreateNewSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\CreateNewSusu\AccountNameAction;
use Domain\Customer\Actions\CreateNewSusu\CreateNewSusuAction;
use Domain\Customer\Actions\CreateNewSusu\PinConfirmationAction;
use Domain\Customer\Actions\CreateNewSusu\ChooseLinkedAccountAction;
use Domain\Customer\Actions\CreateNewSusu\ChooseSusuSchemeAction;
use Domain\Customer\Actions\CreateNewSusu\SusuAmountAction;
use Domain\Customer\Actions\CreateNewSusu\TermsAgreementAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewSusuState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        $steps = json_decode(json: $session->user_inputs, associative: true);

        if (! array_key_exists(key: 'start', array: $steps)) {
            return CreateNewSusuAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'scheme', array: $steps)) {
            return ChooseSusuSchemeAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'account_name', array: $steps)) {
            return AccountNameAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'susu_amount', array: $steps)) {
            return SusuAmountAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'linked_wallet', array: $steps)) {
            return ChooseLinkedAccountAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'terms_conditions', array: $steps)) {
            return TermsAgreementAction::execute(session: $session, session_data: $session_data);
        } elseif (! array_key_exists(key: 'pin_confirmation', array: $steps)) {
            return PinConfirmationAction::execute(session: $session, session_data: $session_data);
        }

        return GeneralMenu::infoNotification(
            message: 'There was a problem. Try again later.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
