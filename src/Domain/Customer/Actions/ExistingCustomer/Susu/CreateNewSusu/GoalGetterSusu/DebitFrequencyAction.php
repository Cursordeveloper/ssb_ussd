<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DebitFrequencyAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['DebitFrequency' => $session_data->user_input]);

        // Return the chooseLinkedWalletMenu
        return CreateGoalGetterSusuMenu::linkedWalletMenu(session: $session);
    }
}
