<?php

declare(strict_types=1);

namespace Domain\Susu\GoalGetterSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\GoalGetterSusu\Menus\Create\GoalGetterSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GoalGetterSusuCreateTargetAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['target_amount' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return GoalGetterSusuCreateMenu::durationMenu(session: $session);
    }
}
