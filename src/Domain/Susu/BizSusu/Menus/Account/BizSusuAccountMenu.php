<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\BizSusu;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuAccountMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Get the account name
        $account_name = json_decode($session->user_inputs, associative: true);

        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: data_get(target: $account_name, key: 'susu_account.business_name')."\n1. Check Balance\n2. Make Payment\n3. Withdrawal\n4. Mini Statement\n5. Pause Susu\n6. Close Susu\n0. Back",
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
