<?php

declare(strict_types=1);

namespace App\States\ExistingCustomer\Account\LinkedWallets;

use App\Menus\Shared\GeneralMenu;
use Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkedWallets\LinkedWalletsAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LinkedWalletsState
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get all customer linked wallets
        $linked_wallets = LinkedWalletsAction::execute(session: $session);

        // Return the linked wallets and terminate the session
        return GeneralMenu::infoNotification(
            message: $linked_wallets,
            session: data_get(target: $session, key: 'session_id'),
        );
    }
}
