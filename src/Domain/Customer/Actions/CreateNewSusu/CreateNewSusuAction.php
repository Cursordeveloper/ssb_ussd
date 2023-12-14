<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\CreateNewSusu;

use App\Menus\Susu\SusuSavingsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateNewSusuAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['start' => true]);

        // Terminate the session
        return SusuSavingsMenu::chooseSusuSchemesMenu(session: $session);
    }
}
