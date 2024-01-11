<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\LinkNewWallet;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewWalletMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SelectNetworkAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Get the
        $networks = ['1' => 'mtn', '2' => 'airteltigo', '3' => 'vodafone'];

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['selectNetwork' => $networks[$session_data->user_input]]);

        // Return the enterNumberMenu
        return LinkNewWalletMenu::enterNumberMenu(session: $session);
    }
}
