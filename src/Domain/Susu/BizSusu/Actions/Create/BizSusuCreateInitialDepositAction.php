<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use Domain\Shared\Action\General\CreateSusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\CreateSusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\BizSusu\Menus\Create\BizSusuCreateMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateInitialDepositAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input (susu_amount)
        return match (true) {
            CreateSusuValidationAction::isNumeric($session_data->user_input) === false => CreateSusuValidationMenu::isNumericMenu(session: $session),
            CreateSusuValidationAction::initialDepositAmountValid($session_data->user_input) === false => CreateSusuValidationMenu::initialDepositAmountMenu(session: $session),

            default => self::initialDepositAmountStore(session: $session, session_data: $session_data)
        };
    }

    public static function initialDepositAmountStore(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['initial_deposit' => $session_data->user_input]);

        // Return the linkedWalletMenu
        return BizSusuCreateMenu::linkedWalletMenu(session: $session);
    }
}
