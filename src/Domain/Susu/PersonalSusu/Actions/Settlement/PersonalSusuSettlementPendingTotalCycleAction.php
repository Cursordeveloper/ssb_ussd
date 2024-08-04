<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use App\Menus\Shared\GeneralMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementPendingMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingTotalCycleAction
{
    public static function execute($session, $user_inputs, $session_data): JsonResponse
    {
        // Return the invalidTotalCycle if user_input is more than [pending_settlements]
        if ((int) $session_data->user_input > data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements')) {
            return PersonalSusuSettlementPendingMenu::invalidTotalCycle(session: $session);
        }

        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['total_cycle' => $session_data->user_input]);

        // Return the noSususAccount
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
