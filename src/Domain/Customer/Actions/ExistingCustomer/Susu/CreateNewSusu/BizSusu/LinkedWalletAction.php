<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\Susu\CreateNewSusu\BizSusu;

use App\Menus\ExistingCustomer\Susu\CreateNewSusu\BizSusu\CreateBizSusuMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::execute(session: $session, user_input: ['LinkedWallet' => $session_data->user_input]);

        // Return the confirmTermsConditionsMenu
        return CreateBizSusuMenu::narrationMenu(session: $session);
    }
}
