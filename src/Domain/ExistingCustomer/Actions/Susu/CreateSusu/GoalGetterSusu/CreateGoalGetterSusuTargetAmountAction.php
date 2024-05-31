<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateGoalGetterSusuTargetAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['target_amount' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return CreateGoalGetterSusuMenu::durationMenu(session: $session);
    }
}
