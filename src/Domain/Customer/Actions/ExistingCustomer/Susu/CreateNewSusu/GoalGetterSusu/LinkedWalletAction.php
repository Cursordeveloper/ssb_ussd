<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\GoalGetterSusu\CreateGoalGetterSusuMenu;
use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\Common\CustomerLinkedWalletsAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the LinkedWalletAction
        if (! CustomerLinkedWalletsAction::execute(session: $session, session_data: $session_data)) {
            return GeneralMenu::invalidInput(session: $session);
        }

        // Return the confirmTermsConditionsMenu
        return CreateGoalGetterSusuMenu::narrationMenu(session: $session);
    }
}
