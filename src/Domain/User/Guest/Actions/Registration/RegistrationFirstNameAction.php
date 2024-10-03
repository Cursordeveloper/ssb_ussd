<?php

declare(strict_types=1);

namespace Domain\User\Guest\Actions\Registration;

use Domain\Shared\Action\General\RegistrationValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\RegistrationValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\User\Guest\Menus\Registration\RegistrationMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegistrationFirstNameAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate and store the user_input
        return match (true) {
            RegistrationValidationAction::isNameLengthValid(user_input: $service_data->user_input) === false => RegistrationValidationMenu::isNameLengthMenu(session: $session),
            RegistrationValidationAction::isNameStringValid(user_input: $service_data->user_input) === false => RegistrationValidationMenu::isNameStringMenu(session: $session),

            default => self::actionExecution(session: $session, service_data: $service_data)
        };
    }

    public static function actionExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['first_name' => $service_data->user_input]);

        // Return the lastNameMenu
        return RegistrationMenu::lastNameMenu(session: $session);
    }
}
