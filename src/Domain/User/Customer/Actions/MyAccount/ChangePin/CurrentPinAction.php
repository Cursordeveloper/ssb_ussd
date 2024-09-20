<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\ChangePin;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyAccount\ChangePin\ChangePinMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class CurrentPinAction
{
    public static function execute(Session $session, $service_data): JsonResponse
    {
        // Validate the user input
        if (ValidatePinAction::execute($service_data->user_input)) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['current_pin' => $service_data->user_input]);

            // Return the enterNewPin
            return ChangePinMenu::enterNewPin(session: $session);
        }

        // Return the invalidCurrentPin
        return ChangePinMenu::invalidCurrentPin(session: $session);
    }
}
