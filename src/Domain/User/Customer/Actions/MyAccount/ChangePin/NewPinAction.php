<?php

declare(strict_types=1);

namespace Domain\User\Customer\Actions\MyAccount\ChangePin;

use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
use Domain\User\Customer\Menus\MyAccount\ChangePin\ChangePinMenu;
use Symfony\Component\HttpFoundation\JsonResponse;

final class NewPinAction
{
    public static function execute(Session $session, $session_data): JsonResponse
    {
        // Validate the user input
        if (ValidatePinAction::execute($session_data->user_input)) {
            SessionInputUpdateAction::updateUserInputs(session: $session, user_input: ['new_pin' => $session_data->user_input]);

            // Return the enterNewPin
            return ChangePinMenu::confirmNewPin(session: $session);
        }

        // Return the invalidNewPin
        return ChangePinMenu::invalidNewPin(session: $session);
    }
}
