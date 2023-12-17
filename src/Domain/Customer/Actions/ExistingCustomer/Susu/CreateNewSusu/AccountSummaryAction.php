<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu;

use App\Menus\ExistingCustomer\Susu\SusuSavingsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountSummaryAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['accountSummary' => 'Done']);

        // Return the pinConfirmationMenu
        return SusuSavingsMenu::pinConfirmationMenu(session: $session);
    }
}
