<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Menus\Withdrawal;

use App\Common\ResponseBuilder;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalMenu
{
    public static function mainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose payment type\n1. Withdraw own amount\n2. Full withdrawal\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function invalidMainMenu(Session $session): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Invalid choice, try again\n1. Withdraw own amount\n2. Full withdrawal\n0. Back",
            session_id: $session->session_id,
        );
    }

    public static function fullWithdrawalConfirmationMenu(Session $session): JsonResponse
    {
        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(message: "You are making full withdrawal on this account. Proceed?\n1. Yes\n2. No", session_id: $session->session_id),
        };
    }

    public static function withdrawalAmountMenu(Session $session): JsonResponse
    {
        // Match statement to determine the menu to return
        return match (true) {
            data_get(target: $session->userInputs(), key: 'susu_account.attributes.withdrawal_status') === 'locked' => self::withdrawalLockedMenu(session: $session),

            default => ResponseBuilder::ussdResourcesResponseBuilder(message: "Enter amount\n", session_id: $session->session_id),
        };
    }

    public static function withdrawalNarrationMenu(Session $session, array $withdrawal_data): JsonResponse
    {
        // Prepare and return the narration
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Total withdrawal: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.amount').'. Service fee: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.fees').'. Total: GHS'.data_get(target: $withdrawal_data, key: 'data.attributes.total_amount').'. Enter PIN to confirm or 2 to Cancel.',
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
