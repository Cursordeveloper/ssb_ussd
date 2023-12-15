<?php

declare(strict_types=1);

namespace App\States\NewCustomer\TermsAndConditions;

use App\Menus\NewCustomer\TermsAndConditionsMenu\TermsAndConditionsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAndConditionsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        $steps = json_decode(json: $session->user_inputs, associative: true);

        if (! array_key_exists(key: 'tcsOne', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['tcsOne' => true]);
            return TermsAndConditionsMenu::main(session: $session);
        } elseif (! array_key_exists(key: 'tcsTwo', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['tcsTwo' => true]);
            return TermsAndConditionsMenu::tcsOne(session: $session);
        } elseif (! array_key_exists(key: 'tcsThree', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['tcsThree' => true]);
            return TermsAndConditionsMenu::tcsTwo(session: $session);
        } elseif (! array_key_exists(key: 'lastTcs', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['lastTcs' => true]);
            return TermsAndConditionsMenu::tcsThree(session: $session);
        } elseif (! array_key_exists(key: 'end', array: $steps)) {
            SessionInputUpdateAction::execute(session: $session, user_input: ['end' => true]);
            return TermsAndConditionsMenu::lastTcs(session: $session);
        }

        return TermsAndConditionsMenu::main(session: $session);
    }
}
