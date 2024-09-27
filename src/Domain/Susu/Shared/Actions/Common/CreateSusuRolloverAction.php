<?php

declare(strict_types=1);

namespace Domain\Susu\Shared\Actions\Common;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CreateSusuRolloverAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            $service_data->user_input === '1' || $service_data->user_input === '2' => self::stateExecution(session: $session, service_data: $service_data),

            default => GeneralMenu::invalidRollOverDebitMenu(session: $session),
        };
    }

    public static function stateExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['rollover' => $service_data->user_input === '1']);

        // Return the linkedWalletMenu
        return GeneralMenu::linkedWalletMenu(session: $session);
    }
}
