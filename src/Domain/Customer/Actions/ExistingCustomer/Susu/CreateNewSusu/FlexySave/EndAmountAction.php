<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class EndAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['end_amount' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return CreateFlexySusuMenu::frequencyMenu(session: $session);
    }
}
