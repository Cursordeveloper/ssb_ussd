<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateInitialDepositAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['initial_deposit' => $session_data->user_input]);

        // Return the linkedWalletMenu
        return PersonalSusuCreateMenu::linkedWalletMenu(session: $session);
    }
}
