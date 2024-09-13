<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateTargetAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (susu_amount)
        return match (true) {
            SusuValidationAction::isNumericValid($session_data->user_input) === false => SusuValidationMenu::isNumericMenu(session: $session),
            SusuValidationAction::targetAmountValid($session_data->user_input) === false => SusuValidationMenu::targetAmountMenu(session: $session),

            default => self::targetAmountStore(session: $session, session_data: $session_data)
        };
    }

    public static function targetAmountStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['target_amount' => $session_data->user_input]);

        // Return the initialDepositMenu
        return GeneralMenu::initialDepositMenu(session: $session);
    }
}
