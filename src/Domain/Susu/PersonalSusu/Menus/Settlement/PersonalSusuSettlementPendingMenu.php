<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\Shared\Menus\Settlement\SusuSettlementMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements') < 1 => SusuSettlementMenu::noPendingSettlementMenu(session: $session),
            data_get(target: $user_inputs, key: 'susu_account.attributes.settlement_status') === 'locked' => SusuSettlementMenu::settlementLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(
                message: data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements').' pending cycle. How many would you like to settle?',
                session_id: $session->session_id
            ),
        };
    }

    public static function invalidTotalCycle(Session $session, int $pending_settlements): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'The value must not be more than '.$pending_settlements.". Please correct your input and try again\n",
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu(Session $session, array $data): JsonResponse
    {
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Settlement Amount: GHS'.data_get(target: $data, key: 'data.attributes.amount').'. Commission: GHS'.data_get(target: $data, key: 'data.attributes.fees').'. Settlement Wallet: '.data_get(target: $data, key: 'data.included.wallet.attributes.account_number').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
