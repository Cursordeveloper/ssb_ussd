<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Settlement\SusuSettlementMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementAllPendingConfirmationAction
{
    public static function execute($session, $session_data): JsonResponse
    {
        // Validate and process the user_input
        return match (true) {
            $session_data->user_input === '1' => self::susuSettlementConfirmationProcessor(session: $session),
            $session_data->user_input === '2' => GeneralMenu::processTerminatedMenu(session: $session),

            default => SusuSettlementMenu::invalidConfirmationMenu(session: $session)
        };
    }

    public static function susuSettlementConfirmationProcessor(Session $session): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['confirmation' => true]);

        // Return the invalidInput
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
