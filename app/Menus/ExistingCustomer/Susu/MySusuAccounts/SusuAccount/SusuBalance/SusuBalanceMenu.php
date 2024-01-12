<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuBalance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceMenu
{
    public static function noSususAccount($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active susu account.\n",
            session_id: $session->session_id,
        );
    }

    public static function confirmation($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter pin to confirm',
            session_id: $session->session_id,
        );
    }

    public static function susuBalanceMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: 'Current Balance: '.data_get(target: $susu_data, key: 'current_balance').', Available Balance: '.data_get(target: $susu_data, key: 'available_balance'),
            session_id: $session->session_id,
        );
    }
}
