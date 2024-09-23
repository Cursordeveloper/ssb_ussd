<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateSusuAmountAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            SusuValidationAction::isNumericValid($service_data->user_input) === false => SusuValidationMenu::isNumericMenu(session: $session),
            SusuValidationAction::susuAmountValid($service_data->user_input) === false => SusuValidationMenu::susuAmountValidMenu(session: $session),

            default => self::stateExecution(session: $session, service_data: $service_data)
        };
    }

    public static function stateExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_amount' => $service_data->user_input]);

        // Return the initialDepositMenu
        return PersonalSusuCreateMenu::initialDepositMenu(session: $session);
    }
}
