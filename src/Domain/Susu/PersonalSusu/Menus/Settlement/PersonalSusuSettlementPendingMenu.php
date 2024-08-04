<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements') < 1 => self::noPendingSettlementMenu(session: $session),
            data_get(target: $user_inputs, key: 'susu_account.attributes.settlement_status') === 'locked' => self::settlementLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(
                message: data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements')." pending. How many cycle?\n",
                session_id: $session->session_id
            ),
        };
    }

    public static function invalidTotalCycle($session): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n",
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session, $data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Settlement Amount: GHS'.data_get(target: $data, key: 'data.attributes.amount').'. Commission: GHS'.data_get(target: $data, key: 'data.attributes.fees').'. Settlement Wallet: '.data_get(target: $data, key: 'data.included.wallet.attributes.account_number').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }

    public static function noPendingSettlementMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::infoResponseBuilder(
            message: 'You do not have any pending settlement.',
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
}
