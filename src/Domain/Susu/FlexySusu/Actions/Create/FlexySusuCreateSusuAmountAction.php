<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use Domain\Shared\Action\General\CreateSusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\CreateSusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateSusuAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (susu_amount)
        return match (true) {
            CreateSusuValidationAction::isNumericValid($session_data->user_input) === false => CreateSusuValidationMenu::isNumericMenu(session: $session),
            CreateSusuValidationAction::susuAmountValid($session_data->user_input) === false => CreateSusuValidationMenu::susuAmountValidMenu(session: $session),

            default => self::susuAmountStore(session: $session, session_data: $session_data)
        };
    }

    public static function susuAmountStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_amount' => $session_data->user_input]);

        // Return the initialDeposit
        return FlexySusuCreateMenu::initialDeposit(session: $session);
    }
}
