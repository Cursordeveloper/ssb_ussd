<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Menus\Settlement;

use App\Common\ResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementAllPendingMenu
{
    public static function mainMenu($session): JsonResponse
    {
        // Return the menu for the susu_scheme
        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: "Choose plan\n1. Previous cycle\n2. All cycles\n3. ",
            session_id: $session->session_id,
        );
    }

    public static function narrationMenu($session): JsonResponse
    {
        // Get the process flow array from the customer session (user inputs)
        $user_inputs = json_decode($session->user_inputs, associative: true);

        return ResponseBuilder::ussdResourcesResponseBuilder(
            message: 'Withdrawal Amount: GHS'.$user_inputs['withdrawal_amount'].'. Susubox Commission: GHS2.00. Enter pin to confirm or 2 to Cancel.',
            session_id: $session->session_id,
        );
    }
}
