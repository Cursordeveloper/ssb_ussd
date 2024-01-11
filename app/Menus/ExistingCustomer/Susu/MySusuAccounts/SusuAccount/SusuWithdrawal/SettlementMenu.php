<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\SusuWithdrawal;

use App\Common\Helpers;
use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SettlementMenu
{
    public static function mainMenu($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "You do not have any active susu account.\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function susuAccountsMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Susu Accounts\n".Helpers::formatSusuAccountsForOutput(data_get(target: $susu_data, key: 'data')).'0. Back',
            session_id: $session->session_id,
        );
    }
}
