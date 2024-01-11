<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\CheckSusuBalance;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CheckBalanceMenu
{
    public static function noSususAccount($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active susu account.\n",
            session_id: $session->session_id,
        );
    }

    public static function susuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Accounts\n".Helpers::formatSusuAccountsForOutput(data_get(target: $susu_data, key: 'data')),
            session_id: $session->session_id,
        );
    }

    public static function invalidSusuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Accounts\n".Helpers::formatSusuAccountsForOutput(data_get(target: $susu_data, key: 'data')),
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
