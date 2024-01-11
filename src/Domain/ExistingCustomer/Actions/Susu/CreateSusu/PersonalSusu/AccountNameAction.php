<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\PersonalSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu\CreatePersonalSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountNameAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['account_name' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return CreatePersonalSusuMenu::susuAmountMenu(session: $session);
    }
}
