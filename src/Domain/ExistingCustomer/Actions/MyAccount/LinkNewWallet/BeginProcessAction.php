<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BeginProcessAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['beginProcess' => true]);

        // Return the selectNetworkMenu
        return LinkNewWalletMenu::selectNetworkMenu(session: $session);
    }
}
