<?php

declare(strict_types=1);

namespace Domain\User\Guest\States\Registration;

use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Guest\Actions\Registration\RegistrationAcceptedTermsAction;
use Domain\User\Guest\Actions\Registration\RegistrationFirstNameAction;
use Domain\User\Guest\Actions\Registration\RegistrationLastNameAction;
use Domain\User\Guest\Actions\Registration\RegistrationPinAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationState
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate inputs and update the database
        return match (true) {
            ! array_key_exists(key: 'first_name', array: $session->userInputs()) => RegistrationFirstNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'last_name', array: $session->userInputs()) => RegistrationLastNameAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'accepted_terms', array: $session->userInputs()) => RegistrationAcceptedTermsAction::execute(session: $session, service_data: $service_data),
            ! array_key_exists(key: 'susubox_pin', array: $session->userInputs()) => RegistrationPinAction::execute(session: $session, service_data: $service_data),

            default => GeneralMenu::invalidInput(session: $session),
        };
    }
}
