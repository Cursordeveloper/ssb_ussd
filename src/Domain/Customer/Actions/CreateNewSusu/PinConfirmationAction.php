<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\CreateNewSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PinConfirmationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['pin_confirmation' => true]);

        // Terminate the session
        return GeneralMenu::infoNotification(
            message: 'Successful: You will receive confirmation shortly.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
