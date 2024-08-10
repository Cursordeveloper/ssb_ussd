<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\Statement;

use App\Common\ResponseBuilder;
use App\Common\Transactions;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuMiniStatementMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Susubox pin',
            session_id: $session->session_id,
        );
    }

    public static function susuMiniStatementMenu($session, $transactions): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: Transactions::formatTransactionsForMenu(data_get(target: $transactions, key: 'data')).'#. Next or 0 Back',
            session_id: $session->session_id,
        );
    }

    public static function susuMiniStatementEndMenu($session, $transactions): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: Transactions::formatTransactionsForMenu(data_get(target: $transactions, key: 'data')),
            session_id: $session->session_id,
        );
    }

    public static function susuNoMiniStatementMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: 'Sorry! no transactions for this account.',
            session_id: $session->session_id,
        );
    }
}
