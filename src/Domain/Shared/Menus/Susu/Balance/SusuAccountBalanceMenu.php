<?php

declare(strict_types=1);

namespace Domain\Shared\Menus\Susu\Balance;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuAccountBalanceMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Enter Susubox pin',
            session_id: $session->session_id,
        );
    }

    public static function susuBalanceMenu($session, array $susu_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::infoResponseBuilder(
            message: 'Current Balance: '.data_get(target: $susu_data, key: 'included.currency.attributes.currency').data_get(target: $susu_data, key: 'attributes.current_balance').', Available Balance: '.data_get(target: $susu_data, key: 'included.currency.attributes.currency').data_get(target: $susu_data, key: 'attributes.available_balance'),
            session_id: $session->session_id,
        );
    }
}
