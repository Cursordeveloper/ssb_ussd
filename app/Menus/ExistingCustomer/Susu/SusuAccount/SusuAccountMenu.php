<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\SusuAccount;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountMenu
{
    public static function mainMenu($session, $session_data): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: $user_inputs['account_name']."\n1. Check Balance\n2. Make Payment\n3. Withdrawal\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu($session, $session_data): JsonResponse
    {
        // Return the account main menu
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Check Balance\n2. Make Payment\n3. Withdrawal\n0. Back",
            session_id: $session->session_id,
        );
    }
}
