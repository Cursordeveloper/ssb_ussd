<?php

declare(strict_types=1);

namespace Domain\Susu\PersonalSusu\Actions\Settlement;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Domain\Susu\PersonalSusu\Menus\Settlement\PersonalSusuSettlementPendingMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class PersonalSusuSettlementPendingTotalCycleAction
{
    public static function execute(Session $session, $user_inputs, $service_data): JsonResponse
    {
        // Get the [pending_settlements] data
        $pending_settlements = data_get(target: $user_inputs, key: 'susu_account.included.stats.settlement.attributes.pending_settlements');

        // Validate and process the user_input
        return match (true) {
            SusuValidationAction::isNumericValid($service_data->user_input) === false => SusuValidationMenu::isNumericMenu(session: $session),
            (int) $service_data->user_input > $pending_settlements => PersonalSusuSettlementPendingMenu::invalidTotalCycle(session: $session, pending_settlements: $pending_settlements),

            default => self::pendingTotalCycleStore(session: $session, service_data: $service_data)
        };
    }

    public static function pendingTotalCycleStore(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['total_cycle' => $service_data->user_input]);

        // Return the noSususAccount
        return GeneralMenu::acceptedSusuTermsMenu(session: $session);
    }
}
