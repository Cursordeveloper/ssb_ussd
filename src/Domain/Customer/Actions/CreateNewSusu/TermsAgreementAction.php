<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\CreateNewSusu;

use App\Menus\ExistingCustomer\Susu\SusuSavingsMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TermsAgreementAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['terms_conditions' => true]);

        // Terminate the session
        return SusuSavingsMenu::pinConfirmationMenu(session: $session);
    }
}
