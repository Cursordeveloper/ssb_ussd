<?php

declare(strict_types=1);

namespace Domain\Susu\BizSusu\Actions\Create;

use Domain\Shared\Action\General\SusuValidationAction;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Menus\General\GeneralMenu;
use Domain\Shared\Menus\General\SusuValidationMenu;
use Domain\Shared\Models\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BizSusuCreateBusinessNameAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user_input and execute the state
        return match (true) {
            SusuValidationAction::accountNameLengthValid($service_data->user_input) === false => SusuValidationMenu::accountNameLengthMenu(session: $session),
            default => self::stateExecution(session: $session, service_data: $service_data)
        };
    }

    public static function stateExecution(Session $session, $service_data): JsonResponse
    {
        // Update the user inputs (steps)
        SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['business_name' => $service_data->user_input]);

        // Return the susuAmountMenu
        return GeneralMenu::susuAmountMenu(session: $session);
    }
}
