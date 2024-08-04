<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementZeroOutMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.attributes.settlement_status') === 'locked' => self::settlementLockedMenu(session: $session),
            data_get(target: $user_inputs, key: 'susu_account.included.stats.cycle.attributes.current_cycle') < 2 => self::invalidCurrentCycle(session: $session),

            default => GeneralMenu::acceptedSusuTermsMenu(session: $session),
        };
    }

    public static function narrationMenu($session, $data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Settlement Amount: GHS'.data_get(target: $data, key: 'data.attributes.amount').'. Commission: GHS'.data_get(target: $data, key: 'data.attributes.fees').'. Cycle: '.data_get(target: $data, key: 'data.attributes.total_cycle').'. Frequency: '.data_get(target: $data, key: 'data.attributes.total_frequency').'. Wallet: '.data_get(target: $data, key: 'data.included.wallet.attributes.account_number').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }

    public static function settlementLockedMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::infoResponseBuilder(
            message: 'The susu account has been locked. Settlement is suspended.',
            session_id: $session->session_id,
        );
    }

    public static function invalidCurrentCycle($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::infoResponseBuilder(
            message: 'The current cycle is not sufficient to take this action.',
            session_id: $session->session_id,
        );
    }
}
