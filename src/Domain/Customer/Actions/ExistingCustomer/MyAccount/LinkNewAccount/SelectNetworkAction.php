<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewAccountMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SelectNetworkAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // TODO: Step 3 - Get the selected network, store
        $networks = ['1' => 'mtn', '2' => 'airteltigo', '3' => 'vodafone'];

        // Execute the SessionInputUpdateAction
        SessionInputUpdateAction::execute(session: $session, user_input: ['selectNetwork' => $networks[$session_data->user_input]]);

        // Return the enterNumberMenu
        return LinkNewAccountMenu::enterNumberMenu(session: $session);
    }
}
