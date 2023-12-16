<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\CreateNewSusu;

use App\Menus\ExistingCustomer\Susu\SusuSavingsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ChooseSusuSchemeAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['scheme' => $session_data->user_input]);

        // Terminate the session
        return SusuSavingsMenu::enterAccountNameMenu(session: $session);
    }
}
