<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\General\CreateSusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\CreateSusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateAccountNameAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (account_name)
        return match (true) {
            CreateSusuValidationAction::accountNameLength($session_data->user_input) === false => CreateSusuValidationMenu::accountNameLengthMenu(session: $session),

            default => self::accountNameStore(session: $session, session_data: $session_data)
        };
    }

    public static function accountNameStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return GoalGetterSusuCreateMenu::targetAmountMenu(session: $session);
    }
}
