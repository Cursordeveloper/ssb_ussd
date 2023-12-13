<?php

declare(strict_types=1);

namespace Domain\Customer\Actions\LinkNewAccount;

use App\Menus\Account\LinkNewAccount\LinkNewAccountMenu;
use Domain\Shared\Action\SessionInputUpdateAction;
use Domain\Shared\Models\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class StepOneAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        SessionInputUpdateAction::execute(session: $session, user_input: ['step1' => 'select_network']);
        return LinkNewAccountMenu::selectNetworkMenu(session: $session);
    }
}
