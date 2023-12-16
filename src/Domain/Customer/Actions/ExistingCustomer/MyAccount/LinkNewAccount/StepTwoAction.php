<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\ExistingCustomer\MyAccount\LinkNewAccount;

use App\Menus\ExistingCustomer\MyAccount\LinkNewWallet\LinkNewAccountMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StepTwoAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // TODO: Step 3 - Get the selected network, store
        $networks = ['1' => 'mtn', '2' => 'airteltigo', '3' => 'vodafone'];
        SessionInputUpdateAction::execute(session: $session, user_input: ['step2' => $networks[$session_data->user_input]]);

        // TODO: Step 4 - Return the (Enter mobile money number) prompt
        return LinkNewAccountMenu::enterNumberMenu(session: $session);
    }
}
