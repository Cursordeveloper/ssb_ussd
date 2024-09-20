<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\SusuWithdrawal;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SusuWithdrawalConfirmationAction
{
    public static function execute($session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['withdrawal_amount' => $service_data->user_input]);

        // Detailed code to post code to susu_service goes here

        // Return the noSususAccount
        return GeneralMenu::requestNotification(session: $session);
    }
}
