<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Withdrawal;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuWithdrawalFullConfirmationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        return match (true) {
            $session_data->user_input === '1' => self::proceed(session: $session),
            $session_data->user_input === '2' => GeneralMenu::terminateSession(session: $session),

            default => GeneralMenu::systemErrorNotification(session: $session)
        };
    }

    public static function proceed(Session $session): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['confirmation' => true]);

        // Return the acceptedSusuTermsMenu
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
