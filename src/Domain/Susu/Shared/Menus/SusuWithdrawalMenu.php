<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalMenu
{
    public static function fullWithdrawalConfirmationMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(message: "You are making full withdrawal on this account. Proceed?\n1. Yes\n2. No", session_id: $session->session_id),
        };
    }

    public static function withdrawalAmountMenu(Session $session): JsonResponse
    {
        // Get the process flow array from the customer session (user_inputs, user_data)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $user_inputs, key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(message: "Enter amount\n", session_id: $session->session_id),
        };
    }

    public static function withdrawalNarrationMenu(Session $session, array $withdrawal_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total withdrawal: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.amount').'. Service fee: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.fees').'. Total: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.total_amount').'. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }

    public static function withdrawalLockedMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::infoResponseBuilder(
            message: 'The susu account has been locked. Settlement is suspended.',
            session_id: $session->session_id,
        );
    }
}
