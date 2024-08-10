<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\FlexySusu;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\FlexySusu\Menus\Create\FlexySusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateFlexySusuAccountNameAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return FlexySusuCreateMenu::susuAmount(session: $session);
    }
}
