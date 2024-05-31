<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu;

use App\Menus\ExistingCustomer\Susu\StartSusu\BizSusu\CreateBizSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateBizSusuBusinessNameAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user_input

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['business_name' => $session_data->user_input]);

        // Return the enterSusuAmountMenu
        return CreateBizSusuMenu::susuAmountMenu(session: $session);
    }
}
