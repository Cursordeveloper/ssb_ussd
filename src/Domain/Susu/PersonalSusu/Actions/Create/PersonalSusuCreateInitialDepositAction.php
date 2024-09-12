<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Create;

use Domain\Shared\Action\General\CreateSusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\CreateSusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Create\PersonalSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuCreateInitialDepositAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (susu_amount)
        return match (true) {
            CreateSusuValidationAction::startWithInteger($session_data->user_input) === false => CreateSusuValidationMenu::startWithIntegerMenu(session: $session),
            CreateSusuValidationAction::startWithTotal($session_data->user_input) === false => CreateSusuValidationMenu::startWithTotalMenu(session: $session),

            default => self::initialDepositStore(session: $session, session_data: $session_data)
        };
    }

    public static function initialDepositStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['initial_deposit' => $session_data->user_input]);

        // Return the linkedWalletMenu
        return PersonalSusuCreateMenu::linkedWalletMenu(session: $session);
    }
}
