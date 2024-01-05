<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\FlexySave;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\FlexySave\CreateFlexySusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class MinRangeAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['min_range' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return CreateFlexySusuMenu::debitTo(session: $session);
    }
}
