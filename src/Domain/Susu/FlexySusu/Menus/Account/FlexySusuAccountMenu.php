<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Menus\Account;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuAccountMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: data_get(target: $session->userInputs(), key: 'susu_account.account_name')."\n1. Check Balance\n2. Make Payment\n3. Withdrawals\n4. Collections\n5. Mini Statement\n6. Lock Account\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Check Balance\n2. Make Payment\n3. Withdrawals\n4. Collections\n5. Mini Statement\n6. Lock Account\n0. Back",
            session_id: $session->session_id,
        );
    }
}
