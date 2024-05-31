<?php

declare(strict_types=1);

namespace App\Menus\ExistingCustomer\Susu\MySusuAccounts\SusuAccount\Shared;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountMiniStatementMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Susubox pin',
            session_id: $session->session_id,
        );
    }

    public static function susuMiniStatementMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "2024-11-10 - Debit: 15.00\n2024-11-11 - Debit: 15.00\n2024-11-11 - Debit: 15.00\n0. Next",
            session_id: $session->session_id,
        );
    }

    public static function susuNoMiniStatementMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: 'Sorry: there are no available transactions for this account.',
            session_id: $session->session_id,
        );
    }
}
