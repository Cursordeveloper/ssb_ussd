<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\CreateNewSusu;

use App\Menus\Susu\SusuSavingsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['susu_amount' => $session_data->user_input]);

        // Terminate the session
        return SusuSavingsMenu::chooseLinkedWalletMenu(session: $session);
    }
}
