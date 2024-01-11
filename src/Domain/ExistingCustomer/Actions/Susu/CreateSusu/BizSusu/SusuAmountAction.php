<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\Susu\CreateSusu\BizSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAmountAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['susu_amount' => $session_data->user_input]);

        // Return the chooseLinkedWalletMenu
        return CreateBizSusuMenu::frequencyMenu(session: $session);
    }
}
