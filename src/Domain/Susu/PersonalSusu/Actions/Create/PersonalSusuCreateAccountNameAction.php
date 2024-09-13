<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateAccountNameAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (account_name)
        return match (true) {
            SusuValidationAction::accountNameLengthValid($session_data->user_input) === false => SusuValidationMenu::accountNameLengthMenu(session: $session),

            default => self::accountNameStore(session: $session, session_data: $session_data)
        };
    }

    public static function accountNameStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $session_data->user_input]);

        // Return the susuAmountMenu
        return GeneralMenu::susuAmountMenu(session: $session);
    }
}
