<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BeginProcessAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::execute(session: $session, user_input: ['beginProcess' => true]);

        // Return the selectNetworkMenu
        return LinkNewWalletMenu::selectNetworkMenu(session: $session);
    }
}
