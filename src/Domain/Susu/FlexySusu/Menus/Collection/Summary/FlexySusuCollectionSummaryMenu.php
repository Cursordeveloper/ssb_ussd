<?php

declare(strict_types=1);

namespace Domain\Susu\FlexySusu\Menus\Collection\Summary;

use App\Common\ResponseBuilder;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FlexySusuCollectionSummaryMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        return GeneralMenu::pinMenu(session: $session);
    }

    public static function narrationMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        return ResponseBuilder::infoResponseBuilder(
            message: 'Total collections: '.data_get(target: $user_inputs, key: 'susu_account.included.stats.collection.attributes.total_successful').'. Total cycles: '.data_get(target: $user_inputs, key: 'susu_account.included.stats.cycle.attributes.total_cycles').'. Current cycle: '.data_get(target: $user_inputs, key: 'susu_account.included.stats.cycle.attributes.current_cycle').'. Total settlement: '.data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.total_settlements').'. Pending settlement: '.data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements'),
            session_id: $session->session_id,
        );
    }
}
