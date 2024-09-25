<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\Balance;

use App\Common\ResponseBuilder;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuBalanceMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return GeneralMenu::pinMenu(session: $session);
    }

    public static function susuBalanceMenu(Session $session, array $susu_data): JsonResponse
    {
        return ResponseBuilder::infoResponseBuilder(
            message: 'Current Balance: '.data_get(target: $susu_data, key: 'included.currency.attributes.currency').' '.data_get(target: $susu_data, key: 'attributes.current_balance').', Available Balance: '.data_get(target: $susu_data, key: 'included.currency.attributes.currency').' '.data_get(target: $susu_data, key: 'attributes.available_balance'),
            session_id: $session->session_id,
        );
    }
}
