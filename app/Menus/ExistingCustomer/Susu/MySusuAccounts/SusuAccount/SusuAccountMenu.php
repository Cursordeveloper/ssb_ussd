<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount;

use App\Common\ResponseBuilder;
use Domain\ExistingCustomer\Actions\Susu\MyAccounts\SusuAccount\SusuAccountAction;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Execute SusuAccountAction action
        return SusuAccountAction::execute(session: $session);
    }

    public static function susuAccountMenu($session, string $account_name): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: $account_name."\n1. Check Balance\n2. Make Payment\n3. Withdrawal\n4. Mini Statement\n5. Pause Susu\n6. Close Susu\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Check Balance\n2. Make Payment\n3. Withdrawal\n4. Mini Statement\n5. Pause Susu\n6. Close Susu\n0. Back",
            session_id: $session->session_id,
        );
    }
}
