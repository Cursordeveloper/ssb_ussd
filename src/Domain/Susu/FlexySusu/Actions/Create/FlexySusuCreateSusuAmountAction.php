<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCreateSusuAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_amount' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return FlexySusuCreateMenu::frequencyMenu(session: $session);
    }
}
