<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Action\General\RegistrationValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\RegistrationValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationLastNameAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and store the user_input
        return match (true) {
            RegistrationValidationAction::isNameLengthValid(user_input: $service_data->user_input) === false => RegistrationValidationMenu::isNameLengthMenu(session: $session),
            RegistrationValidationAction::isNameStringValid(user_input: $service_data->user_input) === false => RegistrationValidationMenu::isNameStringMenu(session: $session),

            default => self::lastNameStore(session: $session, service_data: $service_data)
        };
    }

    public static function lastNameStore(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['last_name' => $service_data->user_input]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
