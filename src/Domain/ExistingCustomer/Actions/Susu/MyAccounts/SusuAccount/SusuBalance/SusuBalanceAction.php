<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuBalance;

use App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance\SusuBalanceMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceAction
{
    public static function execute(Session $session): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_payment' => true]);

        // Return the CheckBalanceMenu
        return SusuBalanceMenu::confirmation(session: $session);
    }
}
