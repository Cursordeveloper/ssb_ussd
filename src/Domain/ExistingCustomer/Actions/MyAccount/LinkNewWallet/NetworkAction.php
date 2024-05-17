<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NetworkAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the linked wallets
        $user_data = json_decode($session->user_data, associative: true);
        $networks = $user_data['linked_account_schemes'];

        // Return invalid response if duration is not in $duration array
        if (! array_key_exists(key: $session_data->user_input, array: $networks)) {
            return LinkNewWalletMenu::invalidMainMenu(session: $session);
        }

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['scheme_resource_id' => $networks[$session_data->user_input]['resource_id']]);

        // Return the enterNumberMenu
        return LinkNewWalletMenu::enterNumberMenu(session: $session);
    }
}
