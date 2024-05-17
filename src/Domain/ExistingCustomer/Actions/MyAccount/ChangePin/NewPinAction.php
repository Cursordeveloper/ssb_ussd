<?php

declare(strict_types=1);

namespace Domain\ExistingCustomer\Actions\MyAccount\ChangePin;

use App\Menus\ExistingCustomer\MyAccount\ChangePin\ChangePinMenu;
use Domain\Shared\Action\Session\SessionInputUpdateAction;
use Domain\Shared\Models\Session\Session;
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
