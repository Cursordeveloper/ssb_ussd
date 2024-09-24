<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Settlement\SusuSettlementMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementZeroOutMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.settlement_status') === 'locked' => SusuSettlementMenu::settlementLockedMenu(session: $session),
            data_get(target: $session->userInputs(), key: 'susu_account.included.stats.cycle.attributes.current_cycle') < 2 => SusuSettlementMenu::lowCurrentCycleMenu(session: $session),
            default => self::confirmationMenu(session: $session, data: $session->userInputs()),
        };
    }

    public static function confirmationMenu(Session $session, array $data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Pending cycle: '.data_get(target: $data, key: 'susu_account.included.stats.settlement.attributes.pending_settlements').'. Current cycle '.data_get(target: $data, key: 'susu_account.included.stats.cycle.attributes.current_cycle')." days. Would you like to proceed?\n1. Yes\n2. No",
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Settlement Amount: GHS'.data_get(target: $data, key: 'data.attributes.amount').'. Commission: GHS'.data_get(target: $data, key: 'data.attributes.fees').'. Cycle: '.data_get(target: $data, key: 'data.attributes.total_cycle').'. Frequency: '.data_get(target: $data, key: 'data.attributes.total_frequency').'. Wallet: '.data_get(target: $data, key: 'data.included.wallet.attributes.account_number').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
