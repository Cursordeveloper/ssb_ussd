<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\PersonalSusu;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ConfirmationAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['Confirmation' => true]);

        // Return the infoNotification and terminate the session
        return GeneralMenu::infoNotification(
            message: 'Successful: You will receive confirmation shortly.',
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
